<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('midtrans_order_id')->nullable()->after('payment_method')->unique();
            $table->string('snap_token')->nullable()->after('midtrans_order_id');
            $table->string('transaction_id')->nullable()->after('snap_token');
            $table->string('transaction_status')->nullable()->after('transaction_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['midtrans_order_id', 'snap_token', 'transaction_id', 'transaction_status']);
        });
    }
};
