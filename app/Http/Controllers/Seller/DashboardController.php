<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\AuctionItem;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPendingAuctions = AuctionItem::where('seller_id', auth()->id())
            ->where('status', 'pending')
            ->count();

        $totalActiveAuctions = AuctionItem::where('seller_id', auth()->id())
            ->where('status', 'active')
            ->count();

        $totalSoldAuctions = Transaction::where('seller_id', auth()->id())
            ->whereHas('auctionItem', function($query) {
                $query->where('status', 'completed');
            })
            ->count();

        $recentAuctions = AuctionItem::where('seller_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentTransactions = Transaction::where('seller_id', auth()->id())
            ->with('auctionItem')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Calculate stats for the dashboard
        $totalAuctions = AuctionItem::where('seller_id', auth()->id())->count();
        $activeAuctions = AuctionItem::where('seller_id', auth()->id())
            ->where('status', 'active')
            ->count();
        $estimatedRevenue = Transaction::where('seller_id', auth()->id())
            ->where('payment_status', 'verified')
            ->sum('final_price');

        $stats = [
            'total_auctions' => $totalAuctions,
            'active_auctions' => $activeAuctions,
            'estimated_revenue' => $estimatedRevenue,
        ];

        // Get all auctions for the table
        $myAuctions = AuctionItem::where('seller_id', auth()->id())
            ->withCount('bids')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('seller.dashboard', compact(
            'totalPendingAuctions',
            'totalActiveAuctions',
            'totalSoldAuctions',
            'recentAuctions',
            'recentTransactions',
            'stats',
            'myAuctions'
        ));
    }
}