@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative h-screen flex items-center justify-center mt-16">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/bg-caffe.png') }}" 
             alt="Cafe No-Limit Interior" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 hero-overlay"></div>
    </div>
    
    <div class="relative z-10 text-center text-white px-6 max-w-4xl">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">
            Selamat Datang di Cafe No-Limit
        </h1>
        
        <p class="text-lg md:text-xl mb-8 leading-relaxed max-w-2xl mx-auto">
            Nikmati suasana nyaman dan hidangan lezat kami. Pesan sekarang dan dapatkan pengalaman kuliner terbaik!
        </p>
        
        <a href="{{ route('menu') }}" 
           class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold px-8 py-4 rounded-lg transition-all transform hover:scale-105 shadow-lg">
            Pesan Sekarang
        </a>
    </div>
</section>
@endsection
