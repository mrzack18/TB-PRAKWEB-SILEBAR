<?php

namespace App\Events;

use App\Models\AuctionItem;
use App\Models\Bid;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewBidPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auction;
    public $bid;

    public function __construct(AuctionItem $auction, Bid $bid)
    {
        $this->auction = $auction;
        $this->bid = $bid;
    }

    public function broadcastOn()
    {
        return new Channel('auction.' . $this->auction->id);
    }

    public function broadcastWith()
    {
        return [
            'current_price' => $this->auction->current_price,
            'bidder' => $this->bid->user->name,
            'bid_amount' => $this->bid->bid_amount,
            'total_bids' => $this->auction->bids()->count(),
            'timestamp' => now()->toIso8601String()
        ];
    }
}