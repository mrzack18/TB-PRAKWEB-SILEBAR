<?php

namespace App\Jobs;

use App\Models\AuctionItem;
use App\Models\Bid;
use App\Models\Transaction;
use App\Models\Notification;
use App\Mail\AuctionWonMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CheckExpiredAuctions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Get all auctions that have expired but still have 'active' status
        $expiredAuctions = AuctionItem::where('status', 'active')
            ->where('end_time', '<=', now())
            ->get();

        foreach ($expiredAuctions as $auction) {
            $this->processExpiredAuction($auction);
        }
    }

    private function processExpiredAuction(AuctionItem $auction)
    {
        // Get highest bid
        $highestBid = $auction->bids()
            ->orderBy('bid_amount', 'desc')
            ->first();

        if (!$highestBid) {
            // No bids, just update status
            $auction->update(['status' => 'completed']);
            return;
        }

        // Create transaction
        $transaction = Transaction::create([
            'auction_item_id' => $auction->id,
            'winner_id' => $highestBid->user_id,
            'seller_id' => $auction->seller_id,
            'final_price' => $highestBid->bid_amount,
            'payment_status' => 'pending',
            'shipping_status' => 'waiting_payment'
        ]);

        // Update auction status
        $auction->update(['status' => 'completed']);

        // Notify winner
        \App\Models\Notification::create([
            'user_id' => $highestBid->user_id,
            'title' => 'Selamat! Anda Menang',
            'message' => "Anda memenangkan lelang '{$auction->title}' dengan harga Rp " . number_format($highestBid->bid_amount),
            'type' => 'winner'
        ]);

        // Notify seller
        \App\Models\Notification::create([
            'user_id' => $auction->seller_id,
            'title' => 'Barang Terjual',
            'message' => "Barang '{$auction->title}' telah terjual dengan harga Rp " . number_format($highestBid->bid_amount),
            'type' => 'winner'
        ]);

        // Send email notification
        Mail::to($highestBid->user->email)
            ->send(new AuctionWonMail($auction, $transaction));
    }
}