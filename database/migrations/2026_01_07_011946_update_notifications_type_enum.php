<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL, we need to modify the column to add new enum values
        DB::statement("ALTER TABLE notifications MODIFY COLUMN type ENUM('bid', 'winner', 'payment', 'shipping', 'verification', 'system', 'auction_end', 'payment_reminder', 'shipping_delay', 'feedback', 'auction_cancelled')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to the original enum values
        DB::statement("ALTER TABLE notifications MODIFY COLUMN type ENUM('bid', 'winner', 'payment', 'shipping', 'verification')");
    }
};
