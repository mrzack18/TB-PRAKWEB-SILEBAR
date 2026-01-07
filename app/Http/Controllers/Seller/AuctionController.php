<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\AuctionItem;
use App\Models\Category;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index()
    {
        // Check for and process expired auctions before displaying the page
        AuctionItem::checkAndProcessExpiredAuctions();

        $auctions = AuctionItem::where('seller_id', auth()->id())
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('seller.auctions.index', compact('auctions'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('seller.auctions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'starting_price' => 'required|numeric|min:0',
            'duration_value' => 'required|integer|min:1|max:30',
            'duration_unit' => 'required|in:minutes,hours,days',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validate image files
        ]);

        // Calculate end time based on duration value and unit
        $startTime = now()->addMinutes(5); // Start in 5 minutes after admin approval
        $endTime = match($request->duration_unit) {
            'minutes' => $startTime->copy()->addMinutes((int) $request->duration_value),
            'hours' => $startTime->copy()->addHours((int) $request->duration_value),
            'days' => $startTime->copy()->addDays((int) $request->duration_value),
            default => $startTime->copy()->addDays((int) $request->duration_value)
        };

        $auction = AuctionItem::create([
            'seller_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'starting_price' => $request->starting_price,
            'current_price' => $request->starting_price,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending' // Will be active after admin approval
        ]);

        // Handle image uploads if provided
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    // Store the image and save the path
                    $path = $image->store('auctions', 'public'); // Store in public/auctions directory

                    // Create AuctionImage record
                    $auction->images()->create([
                        'image_path' => $path,
                        'is_primary' => false // We'll make the first one primary below
                    ]);
                }
            }

            // Set the first image as primary
            $firstImage = $auction->images()->first();
            if ($firstImage) {
                $firstImage->update(['is_primary' => true]);
            }
        }

        return redirect()->route('seller.auctions.index')->with('success', 'Barang lelang berhasil ditambahkan, menunggu verifikasi admin');
    }

    public function edit(AuctionItem $auction)
    {
        // Only allow editing if status is pending or rejected
        if ($auction->seller_id !== auth()->id() || !in_array($auction->status, ['pending', 'rejected'])) {
            abort(403);
        }

        $categories = Category::all();

        // Calculate duration based on the current end_time for the edit form
        if ($auction->end_time) {
            $diffInDays = now()->diffInDays($auction->end_time);
            $diffInHours = now()->diffInHours($auction->end_time);
            $diffInMinutes = now()->diffInMinutes($auction->end_time);

            // Determine the most appropriate unit based on the difference
            if ($diffInMinutes < 60) {
                $durationValue = $diffInMinutes;
                $durationUnit = 'minutes';
            } elseif ($diffInHours < 24) {
                $durationValue = $diffInHours;
                $durationUnit = 'hours';
            } else {
                $durationValue = $diffInDays;
                $durationUnit = 'days';
            }
        } else {
            $durationValue = 7;
            $durationUnit = 'days';
        }

        return view('seller.auctions.edit', compact('auction', 'categories', 'durationValue', 'durationUnit'));
    }

    public function update(Request $request, AuctionItem $auction)
    {
        // Only allow updating if status is pending or rejected
        if ($auction->seller_id !== auth()->id() || !in_array($auction->status, ['pending', 'rejected'])) {
            abort(403);
        }

        // Validate required fields
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'starting_price' => 'required|numeric|min:0',
            'duration_value' => 'nullable|integer|min:1|max:30',
            'duration_unit' => 'nullable|in:minutes,hours,days',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validate image files
        ]);

        // Prepare update data
        $updateData = [
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'starting_price' => $request->starting_price,
            'current_price' => $request->starting_price,
        ];

        // If duration fields are provided, update the start and end times
        if ($request->filled(['duration_value', 'duration_unit'])) {
            $startTime = now()->addMinutes(5); // Start in 5 minutes after admin approval
            $endTime = match($request->duration_unit) {
                'minutes' => $startTime->copy()->addMinutes((int) $request->duration_value),
                'hours' => $startTime->copy()->addHours((int) $request->duration_value),
                'days' => $startTime->copy()->addDays((int) $request->duration_value),
                default => $startTime->copy()->addDays((int) $request->duration_value)
            };

            $updateData['start_time'] = $startTime;
            $updateData['end_time'] = $endTime;
        }

        $auction->update($updateData);

        // Handle new image uploads if provided
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    // Store the image and save the path
                    $path = $image->store('auctions', 'public');

                    // Create AuctionImage record
                    $auction->images()->create([
                        'image_path' => $path,
                        'is_primary' => false
                    ]);
                }
            }
        }

        return redirect()->route('seller.auctions.index')->with('success', 'Barang lelang berhasil diperbarui');
    }

    public function destroy(AuctionItem $auction)
    {
        // Only allow deleting if status is pending or rejected
        if ($auction->seller_id !== auth()->id() || !in_array($auction->status, ['pending', 'rejected'])) {
            abort(403);
        }

        $auction->delete();

        return redirect()->route('seller.auctions.index')->with('success', 'Barang lelang berhasil dihapus');
    }

    public function endEarly(Request $request, AuctionItem $auction)
    {
        // Only allow ending early if the auction belongs to the seller and is active
        if ($auction->seller_id !== auth()->id() || $auction->status !== 'active') {
            abort(403);
        }

        // Update auction status to completed
        $auction->update([
            'status' => 'completed',
            'end_time' => now() // Set end time to now
        ]);

        return redirect()->back()->with('success', 'Lelang berhasil diakhiri lebih awal');
    }
}