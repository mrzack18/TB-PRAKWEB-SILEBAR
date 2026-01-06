<?php

namespace App\Http\Controllers;

use App\Models\AuctionItem;
use App\Models\Category;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index(Request $request)
    {
        $query = AuctionItem::with(['seller', 'images']);

        // Filter by status if provided
        if ($request->has('status')) {
            if ($request->status == '') {
                // When status is explicitly empty (Semua Status), show all statuses
                // Do nothing - don't filter by status
            } else {
                // When a specific status is selected
                $query->where('status', $request->status);
            }
        } else {
            // When status parameter is not provided at all, default to active
            $query->where('status', 'active');
        }

        // Filter by search if provided
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter by category if provided
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by price range if provided
        if ($request->min_price) {
            $query->where('current_price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('current_price', '<=', $request->max_price);
        }

        // Sort options
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('current_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('current_price', 'desc');
                break;
            case 'ending_soon':
                $query->orderBy('end_time', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $auctions = $query->paginate(12);
        $categories = Category::all();

        return view('auctions.index', compact('auctions', 'categories'));
    }

    public function show(AuctionItem $auction)
    {
        $auction->load(['seller', 'images', 'bids.user']);
        $bidHistory = $auction->bidsOrdered()->limit(10)->get();

        return view('auctions.show', compact('auction', 'bidHistory'));
    }
}