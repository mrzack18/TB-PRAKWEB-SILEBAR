<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('seller_id', auth()->id())
            ->whereIn('shipping_status', ['waiting_shipment', 'processing', 'shipped'])
            ->with(['auctionItem', 'winner'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('seller.shipping.index', compact('transactions'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        // Only allow updating if the transaction belongs to the seller and is ready for shipping
        if ($transaction->seller_id !== auth()->id() || !in_array($transaction->shipping_status, ['waiting_shipment', 'processing'])) {
            abort(403);
        }

        $request->validate([
            'shipping_receipt' => 'required|string|max:255'
        ]);

        $transaction->update([
            'shipping_receipt' => $request->shipping_receipt,
            'shipping_status' => 'shipped'
        ]);

        // Notify buyer that item has been shipped
        \App\Models\Notification::create([
            'user_id' => $transaction->winner_id,
            'title' => 'Barang Dikirim',
            'message' => "Barang '{$transaction->auctionItem->title}' telah dikirim dengan nomor resi: {$request->shipping_receipt}",
            'type' => 'shipping'
        ]);

        return redirect()->back()->with('success', 'Nomor resi berhasil disimpan');
    }
}