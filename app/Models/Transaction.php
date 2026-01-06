<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_item_id',
        'winner_id',
        'seller_id',
        'final_price',
        'payment_status',
        'payment_proof',
        'shipping_receipt',
        'shipping_status',
        'commission_amount',
        'seller_amount',
    ];

    protected $casts = [
        'final_price' => 'decimal:2',
    ];

    // Relationships
    public function auctionItem()
    {
        return $this->belongsTo(AuctionItem::class);
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // Scopes
    public function scopePendingPayment($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('payment_status', 'verified');
    }

    public function scopeShipped($query)
    {
        return $query->where('shipping_status', 'shipped');
    }
}