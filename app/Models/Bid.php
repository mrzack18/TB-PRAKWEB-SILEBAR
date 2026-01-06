<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_item_id',
        'user_id',
        'bid_amount',
    ];

    protected $casts = [
        'bid_amount' => 'decimal:2',
    ];

    // Relationships
    public function auctionItem()
    {
        return $this->belongsTo(AuctionItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeForAuction($query, $auctionId)
    {
        return $query->where('auction_item_id', $auctionId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}