<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\AuctionItem;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        // Check for and process expired auctions before displaying the page
        AuctionItem::checkAndProcessExpiredAuctions();

        $transactions = auth()->user()->transactions()
            ->with(['auctionItem', 'auctionItem.images'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('payments.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        // Check for and process expired auctions before displaying the page
        AuctionItem::checkAndProcessExpiredAuctions();

        // Ensure the user can only view their own transactions
        if ($transaction->winner_id !== auth()->id() && $transaction->seller_id !== auth()->id()) {
            abort(403);
        }

        return view('payments.show', compact('transaction'));
    }

    public function create(Request $request, AuctionItem $auction)
    {
        // Check for and process expired auctions before creating payment
        AuctionItem::checkAndProcessExpiredAuctions();

        // Check if auction is completed and has a winner
        if ($auction->status !== 'completed') {
            return redirect()->back()->with('error', 'Lelang belum selesai');
        }

        // Get the highest bid to determine the winner
        $highestBid = $auction->bids()->orderBy('bid_amount', 'desc')->first();

        if (!$highestBid || $highestBid->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda bukan pemenang lelang ini');
        }

        // Check if transaction already exists
        $existingTransaction = Transaction::where('auction_item_id', $auction->id)
            ->where('winner_id', auth()->id())
            ->first();

        if ($existingTransaction) {
            return redirect()->route('payments.show', $existingTransaction);
        }

        // Calculate commission and seller amounts (10% commission, 90% to seller)
        $finalPrice = $highestBid->bid_amount;
        $commissionAmount = $finalPrice * 0.10; // 10% commission
        $sellerAmount = $finalPrice * 0.90; // 90% to seller

        // Create transaction
        $transaction = Transaction::create([
            'auction_item_id' => $auction->id,
            'winner_id' => auth()->id(),
            'seller_id' => $auction->seller_id,
            'final_price' => $finalPrice,
            'payment_status' => 'pending',
            'shipping_status' => 'waiting_payment',
            'commission_amount' => $commissionAmount,
            'seller_amount' => $sellerAmount
        ]);

        return redirect()->route('payments.show', $transaction);
    }

    public function processPayment(Request $request, Transaction $transaction)
    {
        // Check for and process expired auctions before processing payment
        AuctionItem::checkAndProcessExpiredAuctions();

        // Validate the request
        $request->validate([
            'payment_method' => 'required|in:bank_transfer,credit_card,e_wallet',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update transaction with payment info
        $transaction->update([
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending_verification',
        ]);

        // Handle payment proof upload if provided
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $transaction->update([
                'payment_proof' => $path,
            ]);

            // Notify admins about new payment pending verification
            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                \App\Models\Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'Pembayaran Baru Menunggu Verifikasi',
                    'message' => "Pembayaran untuk barang '{$transaction->auctionItem->title}' dari pembeli {$transaction->winner->name} menunggu verifikasi.",
                    'type' => 'payment'
                ]);
            }
        }

        return redirect()->route('payments.show', $transaction)
            ->with('success', 'Pembayaran berhasil diproses. Menunggu verifikasi admin.');
    }

    public function verifyPayment(Request $request, Transaction $transaction)
    {
        // Check for and process expired auctions before verifying payment
        AuctionItem::checkAndProcessExpiredAuctions();

        // Only admin or the seller of the transaction can verify payments
        if (auth()->user()->role !== 'admin' && $transaction->seller_id !== auth()->id()) {
            abort(403);
        }

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
                'shipping_status' => $request->payment_status === 'verified' ? 'waiting_shipment' : 'payment_rejected',
            ]);
        } else {
            $transaction->update([
                'payment_status' => $request->payment_status,
                'shipping_status' => $request->payment_status === 'verified' ? 'waiting_shipment' : 'payment_rejected',
            ]);
        }

        return redirect()->back()->with('success', 'Status pembayaran diperbarui');
    }
}