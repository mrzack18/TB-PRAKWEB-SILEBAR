<?php

namespace App\Jobs;

use App\Models\AuctionItem;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAuctionReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Find auctions that will end in the next 5 minutes
        $upcomingExpirations = AuctionItem::where('status', 'active')
            ->whereBetween('end_time', [
                now()->addMinutes(4),
                now()->addMinutes(6)
            ])
            ->get();

        foreach ($upcomingExpirations as $auction) {
            // Send notification to all bidders
            $bidders = $auction->bids()->pluck('user_id')->unique();

            foreach ($bidders as $userId) {
                Notification::create([
                    'user_id' => $userId,
                    'title' => 'Lelang Segera Berakhir',
                    'message' => "Lelang '{$auction->title}' akan segera berakhir dalam 5 menit. Penawaran tertinggi saat ini: Rp " . number_format($auction->getCurrentHighestBid()) . ". Ayo tingkatkan penawaran Anda untuk memenangkan lelang!",
                    'type' => 'auction_end'
                ]);
            }

            // Also notify the seller
            Notification::create([
                'user_id' => $auction->seller_id,
                'title' => 'Lelang Segera Berakhir',
                'message' => "Lelang barang '{$auction->title}' Anda akan segera berakhir dalam 5 menit. Penawaran tertinggi saat ini: Rp " . number_format($auction->getCurrentHighestBid()) . ". Total penawar: {$auction->bids->count()} orang.",
                'type' => 'auction_end'
            ]);
        }
    }
}