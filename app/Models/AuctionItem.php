<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'category_id',
        'title',
        'description',
        'starting_price',
        'current_price',
        'start_time',
        'end_time',
        'status',
        'verification_note',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($auctionItem) {
            // Notify admins when a new auction item is created and needs verification
            if ($auctionItem->status === 'pending') {
                $admins = User::where('role', 'admin')->get();

                foreach ($admins as $admin) {
                    \App\Models\Notification::create([
                        'user_id' => $admin->id,
                        'title' => 'Barang Baru Menunggu Verifikasi',
                        'message' => "Barang '{$auctionItem->title}' dari penjual {$auctionItem->seller->name} menunggu verifikasi.",
                        'type' => 'verification'
                    ]);
                }
            }
        });

        static::updated(function ($auctionItem) {
            // Notify seller when auction is cancelled
            if ($auctionItem->isDirty('status') && $auctionItem->status === 'cancelled') {
                \App\Models\Notification::create([
                    'user_id' => $auctionItem->seller_id,
                    'title' => 'Lelang Dibatalkan',
                    'message' => "Lelang barang '{$auctionItem->title}' telah dibatalkan. Jika Anda yakin barang ini memenuhi syarat, silakan hubungi admin untuk informasi lebih lanjut atau ajukan kembali.",
                    'type' => 'auction_cancelled'
                ]);

                // Notify all bidders that the auction has been cancelled
                $bidders = $auctionItem->bids()->pluck('user_id')->unique();
                foreach ($bidders as $bidderId) {
                    \App\Models\Notification::create([
                        'user_id' => $bidderId,
                        'title' => 'Lelang Dibatalkan',
                        'message' => "Lelang barang '{$auctionItem->title}' yang Anda ikuti telah dibatalkan. Penawaran Anda telah dikembalikan. Silakan pantau lelang lain yang mungkin Anda minati.",
                        'type' => 'auction_cancelled'
                    ]);
                }
            }
        });
    }

    // Relationships
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(AuctionImage::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function bidsOrdered()
    {
        return $this->hasMany(Bid::class)->orderBy('bid_amount', 'desc');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Accessors
    public function getTimeRemainingAttribute()
    {
        if ($this->end_time->isPast()) {
            return '00:00:00';
        }

        $diff = $this->end_time->diff(now());
        return $diff->format('%h:%I:%S');
    }

    public function getIsExpiredAttribute()
    {
        return $this->end_time->isPast();
    }

    // Methods
    public function getCurrentHighestBid()
    {
        return $this->bids()->max('bid_amount') ?: $this->starting_price;
    }

    public function getSecondsRemainingAttribute()
    {
        if ($this->end_time->isPast()) {
            return 0;
        }

        return (int) now()->diffInSeconds($this->end_time);
    }

    public static function checkAndProcessExpiredAuctions()
    {
        // Get all auctions that have expired but still have 'active' status
        $expiredAuctions = self::where('status', 'active')
            ->where('end_time', '<=', now())
            ->get();

        foreach ($expiredAuctions as $auction) {
            // Double check that the auction is actually expired to avoid race conditions
            if ($auction->isExpired) {
                $auction->processExpiredAuction();
            }
        }
    }

    public function processExpiredAuction()
    {
        // Get highest bid
        $highestBid = $this->bids()
            ->orderBy('bid_amount', 'desc')
            ->first();

        if (!$highestBid) {
            // No bids, just update status and notify seller
            $this->update(['status' => 'completed']);

            // Notify seller that auction ended with no bids
            \App\Models\Notification::create([
                'user_id' => $this->seller_id,
                'title' => 'Lelang Berakhir Tanpa Penawaran',
                'message' => "Lelang barang '{$this->title}' telah berakhir tanpa ada penawaran.",
                'type' => 'auction_end'
            ]);

            return;
        }

        // Check if transaction already exists to avoid duplicates
        $existingTransaction = \App\Models\Transaction::where('auction_item_id', $this->id)->first();
        if ($existingTransaction) {
            // Transaction already exists, skip processing
            return;
        }

        // Create transaction
        $transaction = \App\Models\Transaction::create([
            'auction_item_id' => $this->id,
            'winner_id' => $highestBid->user_id,
            'seller_id' => $this->seller_id,
            'final_price' => $highestBid->bid_amount,
            'payment_status' => 'pending',
            'shipping_status' => 'waiting_payment'
        ]);

        // Update auction status
        $this->update(['status' => 'completed']);

        // Notify winner
        \App\Models\Notification::create([
            'user_id' => $highestBid->user_id,
            'title' => 'Selamat! Anda Menang',
            'message' => "Anda memenangkan lelang '{$this->title}' dengan harga final Rp " . number_format($highestBid->bid_amount) . ". Silakan segera lakukan pembayaran untuk menyelesaikan transaksi.",
            'type' => 'winner'
        ]);

        // Notify seller
        \App\Models\Notification::create([
            'user_id' => $this->seller_id,
            'title' => 'Barang Terjual',
            'message' => "Barang '{$this->title}' Anda telah terjual kepada {$highestBid->user->name} dengan harga final Rp " . number_format($highestBid->bid_amount) . ". Total komisi: Rp " . number_format($highestBid->bid_amount * 0.1) . ", Anda akan menerima: Rp " . number_format($highestBid->bid_amount * 0.9) . ".",
            'type' => 'winner'
        ]);

        // Notify seller about payment reminder
        \App\Models\Notification::create([
            'user_id' => $this->seller_id,
            'title' => 'Pembayaran Menunggu',
            'message' => "Pembayaran untuk barang '{$this->title}' telah terjual seharga Rp " . number_format($highestBid->bid_amount) . " kepada {$highestBid->user->name}. Menunggu pembayaran dari pembeli. Estimasi pembayaran dalam 3x24 jam.",
            'type' => 'payment_reminder'
        ]);

        // Send email notification
        \Illuminate\Support\Facades\Mail::to($highestBid->user->email)
            ->send(new \App\Mail\AuctionWonMail($this, $transaction));
    }
}