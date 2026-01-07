<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuctionItem;
use App\Models\Notification;
use Illuminate\Http\Request;

class AuctionVerificationController extends Controller
{
    public function index()
    {
        $pendingAuctions = AuctionItem::with(['seller', 'category', 'images'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        return view('admin.verifications.index', compact('pendingAuctions'));
    }

    public function approve(AuctionItem $auction)
    {
        $auction->update([
            'status' => 'active',
            'start_time' => now()
        ]);

        // Notify seller
        Notification::create([
            'user_id' => $auction->seller_id,
            'title' => 'Barang Disetujui - Lelang Dimulai',
            'message' => "Barang '{$auction->title}' telah disetujui dan aktif dilelang. Lelang akan berlangsung hingga {$auction->end_time->format('d M Y H:i')}. Harap pantau lelang secara berkala untuk informasi penawaran terbaru.",
            'type' => 'verification'
        ]);

        return redirect()->back()->with('success', 'Barang berhasil disetujui');
    }

    public function reject(Request $request, AuctionItem $auction)
    {
        $request->validate([
            'verification_note' => 'required|string|min:10'
        ]);

        $auction->update([
            'status' => 'rejected',
            'verification_note' => $request->verification_note
        ]);

        // Notify seller
        Notification::create([
            'user_id' => $auction->seller_id,
            'title' => 'Barang Ditolak',
            'message' => "Barang '{$auction->title}' ditolak dengan alasan: {$request->verification_note}. Silakan perbaiki sesuai saran admin dan ajukan kembali untuk diverifikasi.",
            'type' => 'verification'
        ]);

        return redirect()->back()->with('success', 'Barang ditolak');
    }
}