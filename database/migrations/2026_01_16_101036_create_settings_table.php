<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text');
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            ['key' => 'cafe_name', 'value' => 'Cafe No-Limit', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'hero_title', 'value' => 'Selamat Datang di Cafe No-Limit', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'hero_description', 'value' => 'Nikmati suasana nyaman dan hidangan lezat kami. Pesan sekarang melalui QR Code di meja Anda atau klik tombol di bawah.', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/cafenolimit', 'type' => 'url', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/cafenolimit', 'type' => 'url', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/cafenolimit', 'type' => 'url', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
