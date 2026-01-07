<?php

namespace App\Jobs;

use App\Models\AuctionItem;

class CheckExpiredAuctions
{
    public function handle()
    {
        // Use the method in AuctionItem model to check and process expired auctions
        AuctionItem::checkAndProcessExpiredAuctions();
    }
}