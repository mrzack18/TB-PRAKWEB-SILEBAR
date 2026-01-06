<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update payment_status enum to include all possible values
        DB::statement("ALTER TABLE transactions MODIFY payment_status ENUM('pending', 'pending_verification', 'verified', 'rejected')");

        // Update shipping_status enum to include all possible values
        DB::statement("ALTER TABLE transactions MODIFY shipping_status ENUM('waiting_payment', 'waiting_shipment', 'processing', 'shipped', 'delivered', 'completed', 'payment_rejected')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original values
        DB::statement("ALTER TABLE transactions MODIFY payment_status ENUM('pending', 'paid', 'verified')");
        DB::statement("ALTER TABLE transactions MODIFY shipping_status ENUM('waiting_payment', 'processing', 'shipped', 'delivered', 'completed')");
    }
};
