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
}