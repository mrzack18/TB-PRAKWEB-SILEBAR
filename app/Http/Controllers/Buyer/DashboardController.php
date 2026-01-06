<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $followedAuctions = auth()->user()->bids()
            ->with('auctionItem')
            ->select('auction_item_id')
            ->distinct()
            ->limit(5)
            ->get()
            ->pluck('auctionItem');

        $wonAuctions = Transaction::where('winner_id', auth()->id())
            ->with('auctionItem')
            ->limit(5)
            ->get();

        $bidHistory = Bid::where('user_id', auth()->id())
            ->with('auctionItem')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Calculate stats
        $bidsCount = Bid::where('user_id', auth()->id())->count();
        $wonAuctionsCount = Transaction::where('winner_id', auth()->id())->count();

        $stats = [
            'bids_count' => $bidsCount,
            'won_auctions' => $wonAuctionsCount,
        ];

        return view('buyer.dashboard', compact(
            'followedAuctions',
            'wonAuctions',
            'bidHistory',
            'stats'
        ));
    }
}