<?php

namespace App\Http\Controllers;

use App\Models\AuctionItem;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $auctions = AuctionItem::with(['seller', 'images'])
            ->where('status', 'active')
            ->orderBy('end_time', 'asc')
            ->limit(12)
            ->get();
            
        $categories = Category::all();

        return view('home', compact('auctions', 'categories'));
    }
}