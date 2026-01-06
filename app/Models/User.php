<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function auctionItems()
    {
        return $this->hasMany(AuctionItem::class, 'seller_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function wonAuctions()
    {
        return $this->hasMany(Transaction::class, 'winner_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'seller_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)->latest();
    }

    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class)->where('is_read', false)->latest();
    }

    // Scopes
    public function scopeSellers($query)
    {
        return $query->where('role', 'seller');
    }

    public function scopeBuyers($query)
    {
        return $query->where('role', 'buyer');
    }
    
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }
}