<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\AuctionItem;
use App\Models\Bid;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function followed()
    {
        // Check for and process expired auctions before displaying the page
        AuctionItem::checkAndProcessExpiredAuctions();

        $followedAuctions = AuctionItem::whereIn('id', function($query) {
            $query->select('auction_item_id')
                  ->from('bids')
                  ->where('user_id', auth()->id());
        })
        ->with(['seller', 'images'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('buyer.auctions.followed', compact('followedAuctions'));
    }

    public function follow(Request $request, AuctionItem $auction)
    {
        // Just place a minimal bid to "follow" the auction
        $minBid = $auction->current_price + 10000;
        
        $bid = Bid::create([
            'auction_item_id' => $auction->id,
            'user_id' => auth()->id(),
            'bid_amount' => $minBid
        ]);

        // Update the current price
        $auction->update(['current_price' => $minBid]);

        return response()->json(['success' => true]);
    }
}