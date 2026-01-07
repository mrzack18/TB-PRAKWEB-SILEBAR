<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\User;
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
        // Load relationships to ensure they're available when creating notifications
        $transaction->load(['auctionItem', 'winner', 'seller']);

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

        // Refresh the transaction to get the updated values
        $transaction->refresh();

        if ($request->payment_status === 'verified') {
            // Notify seller to ship the item
            Notification::create([
                'user_id' => $transaction->seller_id,
                'title' => 'Pembayaran Diverifikasi - Segera Kirim Barang',
                'message' => "Pembayaran sebesar Rp " . number_format($transaction->final_price) . " untuk barang '{$transaction->auctionItem->title}' telah diverifikasi. Silakan kirim barang ke alamat pembeli: {$transaction->winner->address} dalam waktu 2x24 jam. Komisi yang diterima: Rp " . number_format($transaction->commission_amount) . ", Anda akan menerima: Rp " . number_format($transaction->seller_amount) . ".",
                'type' => 'payment'
            ]);

            // Notify buyer that payment is verified
            Notification::create([
                'user_id' => $transaction->winner_id,
                'title' => 'Pembayaran Diverifikasi - Barang Akan Dikirim',
                'message' => "Pembayaran Anda sebesar Rp " . number_format($transaction->final_price) . " untuk barang '{$transaction->auctionItem->title}' telah diverifikasi. Penjual {$transaction->seller->name} akan segera mengirim barangnya. Silakan pantau status pengiriman di halaman transaksi Anda.",
                'type' => 'payment'
            ]);
        } else {
            // Notify buyer that payment was rejected
            Notification::create([
                'user_id' => $transaction->winner_id,
                'title' => 'Pembayaran Ditolak',
                'message' => "Pembayaran Anda untuk barang '{$transaction->auctionItem->title}' telah ditolak. Alasan: " . ($request->verification_note ?? 'Tidak ada alasan yang diberikan') . ". Silakan upload bukti pembayaran yang valid atau hubungi admin untuk informasi lebih lanjut.",
                'type' => 'payment'
            ]);
        }

        return redirect()->back()->with('success', 'Status pembayaran diperbarui');
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);
        $transaction->update([
            'payment_proof' => $request->file('payment_proof')->store('payment_proofs', 'public'),
            'payment_status' => 'pending_verification'
        ]);

        // Notify admins about new payment pending verification
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Pembayaran Baru Menunggu Verifikasi',
                'message' => "Pembayaran untuk barang '{$transaction->auctionItem->title}' dari pembeli {$transaction->winner->name} menunggu verifikasi.",
                'type' => 'payment'
            ]);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah dan menunggu verifikasi');
    }
}