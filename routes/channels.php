<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('auction.{auctionId}', function ($user, $auctionId) {
    // User can listen to auction updates if they are authenticated
    return !is_null($user);
});