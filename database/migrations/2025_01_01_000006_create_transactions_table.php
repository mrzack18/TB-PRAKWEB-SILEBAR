<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_item_id')->constrained('auction_items')->onDelete('cascade');
            $table->foreignId('winner_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->decimal('final_price', 15, 2);
            $table->enum('payment_status', ['pending', 'paid', 'verified'])->default('pending');
            $table->string('payment_proof')->nullable();
            $table->string('shipping_receipt')->nullable();
            $table->enum('shipping_status', ['waiting_payment', 'processing', 'shipped', 'delivered', 'completed'])->default('waiting_payment');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};