@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-24 max-w-6xl">
    <!-- Page Title -->
    <h1 class="text-4xl md:text-5xl font-bold mb-8">Tentang Kami</h1>

    <!-- Introduction -->
    <div class="mb-12">
        <p class="text-lg text-gray-700 leading-relaxed">
            Kafe No-Limit adalah tempat yang nyaman dan modern untuk menikmati kopi berkualitas tinggi, makanan lezat, dan suasana yang santai. Kami berkomitmen untuk menyediakan pengalaman yang tak terlupakan bagi setiap pelanggan.
        </p>
    </div>

    <!-- Sejarah Kami -->
    <div class="mb-12">
        <h2 class="text-2xl md:text-3xl font-bold mb-4">Sejarah Kami</h2>
        <p class="text-lg text-gray-700 leading-relaxed">
            Kafe No-Limit didirikan pada tahun 2020 oleh sekelompok pecinta kopi yang bersemangat. Kami memulai dengan visi untuk menciptakan ruang di mana orang dapat berkumpul, bersantai, dan menikmati kopi terbaik di kota. Sejak itu, kami telah berkembang menjadi tujuan populer bagi para penggemar kopi dan makanan.
        </p>
    </div>

    <!-- Visi dan Misi -->
    <div class="mb-12">
        <h2 class="text-2xl md:text-3xl font-bold mb-4">Visi dan Misi</h2>
        <p class="text-lg text-gray-700 leading-relaxed">
            Visi kami adalah menjadi kafe pilihan utama bagi komunitas lokal, yang dikenal karena kualitas kopi, makanan, dan layanan pelanggan yang luar biasa. Misi kami adalah untuk terus berinovasi dalam menu kami, menciptakan suasana yang ramah dan inklusif, dan memberikan pengalaman yang tak terlupakan bagi setiap pelanggan.
        </p>
    </div>

    <!-- Suasana Kafe -->
    <div class="mb-12">
        <h2 class="text-2xl md:text-3xl font-bold mb-4">Suasana Kafe</h2>
        <p class="text-lg text-gray-700 leading-relaxed">
            Kafe No-Limit menawarkan suasana yang modern dan nyaman, dengan desain interior yang stylish dan pencahayaan yang hangat. Kami memiliki area tempat duduk yang luas, termasuk sofa yang nyaman, meja kerja, dan area luar ruangan yang menyenangkan. Musik latar yang santai dan aroma kopi yang menggoda menciptakan suasana yang sempurna untuk bersantai, bekerja, atau bertemu teman.
        </p>
    </div>

    <!-- Gallery Images -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="overflow-hidden rounded-lg shadow-lg">
            <img src="{{ asset('images/gallery/cafe-1.png') }}" 
                 alt="Interior Cafe No-Limit 1" 
                 class="w-full h-80 object-cover hover:scale-105 transition-transform duration-300">
        </div>
        <div class="overflow-hidden rounded-lg shadow-lg">
            <img src="{{ asset('images/gallery/cafe-2.png') }}" 
                 alt="Interior Cafe No-Limit 2" 
                 class="w-full h-80 object-cover hover:scale-105 transition-transform duration-300">
        </div>
        <div class="overflow-hidden rounded-lg shadow-lg">
            <img src="{{ asset('images/gallery/cafe-3.png') }}" 
                 alt="Interior Cafe No-Limit 3" 
                 class="w-full h-80 object-cover hover:scale-105 transition-transform duration-300">
        </div>
    </div>

    <!-- Call to Action -->
    
    </div>
</div>
@endsection
