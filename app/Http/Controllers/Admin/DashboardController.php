<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuctionItem;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalSellers = User::sellers()->count();
        $totalBuyers = User::buyers()->count();
        $totalAuctions = AuctionItem::count();
        $totalActiveAuctions = AuctionItem::active()->count();
        $totalCompletedAuctions = AuctionItem::completed()->count();
        $totalPendingAuctions = AuctionItem::where('status', 'pending')->count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::where('payment_status', 'verified')->sum('final_price');

        // Get recent data for dashboard
        $recentUsers = User::latest()->limit(3)->get();
        $recentAuctions = AuctionItem::with(['seller', 'images'])->latest()->limit(3)->get();
        $recentPendingAuctions = AuctionItem::with(['seller', 'images'])->where('status', 'pending')->latest()->limit(3)->get();

        $stats = [
            'total_users' => $totalUsers,
            'total_sellers' => $totalSellers,
            'total_buyers' => $totalBuyers,
            'total_auctions' => $totalAuctions,
            'active_auctions' => $totalActiveAuctions,
            'completed_auctions' => $totalCompletedAuctions,
            'pending_auctions' => $totalPendingAuctions,
            'total_transactions' => $totalTransactions,
            'total_revenue' => $totalRevenue,
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recentUsers',
            'recentAuctions',
            'recentPendingAuctions'
        ));
    }
}