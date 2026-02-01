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
        DB::statement("ALTER TABLE orders MODIFY status VARCHAR(255) DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting to enum is tricky without knowing exact previous state, 
        // but this is the best effort.
        DB::statement("ALTER TABLE orders MODIFY status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending'");
    }
};
