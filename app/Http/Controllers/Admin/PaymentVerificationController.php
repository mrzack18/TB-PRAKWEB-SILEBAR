<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        $pendingPayments = Transaction::where('payment_status', 'pending_verification')
            ->with(['auctionItem', 'winner'])
            ->paginate(20);

        return view('admin.payments.index', compact('pendingPayments'));
    }

    public function verify(Request $request, Transaction $transaction)
    {
        $request->validate([
            'payment_status' => 'required|in:verified,rejected',
        ]);

        // Calculate commission and seller amounts if not already calculated
        if ($transaction->seller_amount == 0 && $transaction->commission_amount == 0) {
            $finalPrice = $transaction->final_price;
            $commissionAmount = $finalPrice * 0.10; // 10% commission
            $sellerAmount = $finalPrice * 0.90; // 90% to seller

            $transaction->update([
                'commission_amount' => $commissionAmount,
                'seller_amount' => $sellerAmount,
                'payment_status' => $request->payment_status,
                'shipping_status' => $request->payment_status === 'verified' ? 'waiting_shipment' : 'payment_rejected'
            ]);
        } else {
            $transaction->update([
                'payment_status' => $request->payment_status,
                'shipping_status' => $request->payment_status === 'verified' ? 'waiting_shipment' : 'payment_rejected'
            ]);
        }

        if ($request->payment_status === 'verified') {
            // Notify seller to ship the item
            \App\Models\Notification::create([
                'user_id' => $transaction->seller_id,
                'title' => 'Pembayaran Diverifikasi',
                'message' => "Pembayaran untuk barang '{$transaction->auctionItem->title}' telah diverifikasi. Silakan kirim barangnya.",
                'type' => 'payment'
            ]);

            // Notify buyer that payment is verified
            \App\Models\Notification::create([
                'user_id' => $transaction->winner_id,
                'title' => 'Pembayaran Diverifikasi',
                'message' => "Pembayaran Anda untuk barang '{$transaction->auctionItem->title}' telah diverifikasi. Penjual akan segera mengirim barangnya.",
                'type' => 'payment'
            ]);
        } else {
            // Notify buyer that payment was rejected
            \App\Models\Notification::create([
                'user_id' => $transaction->winner_id,
                'title' => 'Pembayaran Ditolak',
                'message' => "Pembayaran Anda untuk barang '{$transaction->auctionItem->title}' telah ditolak. Silakan coba lagi atau hubungi admin.",
                'type' => 'payment'
            ]);
        }

        return redirect()->back()->with('success', 'Status pembayaran diperbarui');
    }
}