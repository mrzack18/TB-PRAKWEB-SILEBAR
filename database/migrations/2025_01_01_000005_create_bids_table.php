<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_item_id')->constrained('auction_items')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('bid_amount', 15, 2);
            $table->timestamps();
            
            $table->index(['auction_item_id', 'bid_amount']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bids');
    }
};