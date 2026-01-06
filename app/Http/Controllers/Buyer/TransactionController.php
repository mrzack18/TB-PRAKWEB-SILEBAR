<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('winner_id', auth()->id())
            ->with(['auctionItem', 'seller'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('buyer.transactions.index', compact('transactions'));
    }
}