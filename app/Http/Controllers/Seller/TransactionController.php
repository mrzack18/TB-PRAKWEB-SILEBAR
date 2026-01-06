<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('seller_id', auth()->id())
            ->with(['auctionItem', 'winner'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('seller.transactions.index', compact('transactions'));
    }

    public function updateShippingStatus(Request $request, Transaction $transaction)
    {
        // Ensure the transaction belongs to the seller
        if ($transaction->seller_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'shipping_status' => 'required|in:processing,shipped,delivered,completed'
        ]);

        $transaction->update([
            'shipping_status' => $request->shipping_status
        ]);

        // Notify buyer about shipping status update
        if ($request->shipping_status === 'shipped') {
            Notification::create([
                'user_id' => $transaction->winner_id,
                'title' => 'Barang Dikirim',
                'message' => "Barang '{$transaction->auctionItem->title}' telah dikirim. Silakan pantau pengiriman.",
                'type' => 'shipping'
            ]);
        } elseif ($request->shipping_status === 'delivered') {
            Notification::create([
                'user_id' => $transaction->winner_id,
                'title' => 'Barang Sampai',
                'message' => "Barang '{$transaction->auctionItem->title}' telah sampai. Silakan periksa dan konfirmasi penerimaan.",
                'type' => 'shipping'
            ]);
        } elseif ($request->shipping_status === 'completed') {
            Notification::create([
                'user_id' => $transaction->winner_id,
                'title' => 'Transaksi Selesai',
                'message' => "Transaksi untuk barang '{$transaction->auctionItem->title}' telah selesai.",
                'type' => 'shipping'
            ]);
        }

        return redirect()->back()->with('success', 'Status pengiriman diperbarui');
    }
}