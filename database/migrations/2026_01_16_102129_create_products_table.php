<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;  // ← TAMBAHKAN INI

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 0);
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Insert sample products
        DB::table('products')->insert([
            // Makanan
            ['category_id' => 1, 'name' => 'French Toast', 'slug' => 'french-toast', 'price' => 17000, 'image' => 'french-toast.jpg', 'is_available' => true, 'order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 1, 'name' => 'No Limit Toast', 'slug' => 'no-limit-toast', 'price' => 17000, 'image' => 'no-limit-toast.jpg', 'is_available' => true, 'order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 1, 'name' => 'French Fries', 'slug' => 'french-fries', 'price' => 15000, 'image' => 'french-fries.jpg', 'is_available' => true, 'order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 1, 'name' => 'Indomie Goreng / Rebus', 'slug' => 'indomie-goreng-rebus', 'price' => 15000, 'image' => 'indomie.jpg', 'is_available' => true, 'order' => 4, 'created_at' => now(), 'updated_at' => now()],
            
            // Minuman
            ['category_id' => 2, 'name' => 'No Limit Coffee', 'slug' => 'no-limit-coffee', 'price' => 20000, 'image' => 'no-limit-coffee.jpg', 'is_available' => true, 'order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 2, 'name' => 'Cappuccino', 'slug' => 'cappuccino', 'price' => 18000, 'image' => 'cappuccino.jpg', 'is_available' => true, 'order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 2, 'name' => 'Red Velvet', 'slug' => 'red-velvet', 'price' => 18000, 'image' => 'red-velvet.jpg', 'is_available' => true, 'order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 2, 'name' => 'Caramel Machiato', 'slug' => 'caramel-machiato', 'price' => 23000, 'image' => 'caramel-machiato.jpg', 'is_available' => true, 'order' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
