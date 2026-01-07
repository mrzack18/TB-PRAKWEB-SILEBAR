<?php

namespace App\Http\Controllers;

use App\Models\AuctionItem;
use App\Models\Bid;
use App\Events\NewBidPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

class BidController extends Controller
{
    public function store(Request $request, AuctionItem $auction)
    {
        // Check for and process expired auctions before placing a bid
        AuctionItem::checkAndProcessExpiredAuctions();

        // Check if user is a buyer
        if (auth()->user()->role !== 'buyer') {
            return response()->json(['error' => 'Hanya pembeli yang dapat melakukan penawaran'], 403);
        }

        $request->validate([
            'bid_amount' => [
                'required',
                'numeric',
                'min:' . ($auction->current_price + 10000),
            ]
        ]);

        // Check if auction is still active (after processing expired auctions)
        if ($auction->isExpired) {
            return response()->json(['error' => 'Lelang sudah berakhir'], 400);
        }

        // Create bid in transaction
        DB::transaction(function() use ($request, $auction) {
            // Create bid
            $bid = Bid::create([
                'auction_item_id' => $auction->id,
                'user_id' => auth()->id(),
                'bid_amount' => $request->bid_amount
            ]);

            // Update current price
            $auction->update(['current_price' => $request->bid_amount]);

            // Check if auction should be extended (if bid is placed in last 5 minutes)
            $extensionMinutes = 5;
            $timeRemaining = $auction->getSecondsRemainingAttribute();
            $extensionSeconds = $extensionMinutes * 60;

            if ($timeRemaining <= $extensionSeconds) {
                // Extend auction end time by 5 minutes
                $auction->update([
                    'end_time' => $auction->end_time->addMinutes($extensionMinutes)
                ]);
            }

            // Broadcast event
            broadcast(new NewBidPlaced($auction, $bid));

            // Create notification for other bidders
            $this->notifyOtherBidders($auction, $bid);
        });

        return response()->json([
            'success' => true,
            'message' => 'Penawaran berhasil!',
            'new_price' => $request->bid_amount
        ]);
    }

    private function notifyOtherBidders($auction, $newBid)
    {
        $otherBidders = $auction->bids()
            ->where('user_id', '!=', $newBid->user_id)
            ->select('user_id')
            ->distinct()
            ->get()
            ->pluck('user_id');

        foreach ($otherBidders as $userId) {
            // Get the user's highest bid for this auction
            $userHighestBid = $auction->bids()
                ->where('user_id', $userId)
                ->orderBy('bid_amount', 'desc')
                ->first();

            $userBidAmount = $userHighestBid ? $userHighestBid->bid_amount : 0;

            \App\Models\Notification::create([
                'user_id' => $userId,
                'title' => 'Tawaran Anda Terlampaui',
                'message' => "Penawaran Anda sebesar Rp " . number_format($userBidAmount) . " pada barang '{$auction->title}' telah dilampaui oleh penawar lain. Penawaran tertinggi saat ini adalah Rp " . number_format($newBid->bid_amount) . ".",
                'type' => 'bid'
            ]);
        }

        // Notify the seller about the new bid
        \App\Models\Notification::create([
            'user_id' => $auction->seller_id,
            'title' => 'Penawaran Baru untuk Barang Anda',
            'message' => "Ada penawaran baru sebesar Rp " . number_format($newBid->bid_amount) . " untuk barang '{$auction->title}' Anda. Penawar: {$newBid->user->name}. Waktu lelang tersisa: {$auction->getTimeRemainingAttribute()}.",
            'type' => 'bid'
        ]);
    }
}