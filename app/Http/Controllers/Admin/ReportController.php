<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['auctionItem', 'winner', 'seller'])
            ->where('payment_status', 'verified')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.reports.index', compact('transactions'));
    }

    public function export()
    {
        // Export logic would go here
        return redirect()->back()->with('success', 'Laporan berhasil diexport');
    }
}