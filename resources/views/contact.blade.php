@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-24 max-w-6xl">
    <!-- Page Title -->
    <h1 class="text-4xl md:text-5xl font-bold mb-12">Kontak Kami</h1>

    <!-- Lokasi Section -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold mb-4">Lokasi</h2>
        <p class="text-lg text-gray-700 mb-6">Jl. Merdeka No. 123, Jakarta Pusat, Indonesia</p>
        
        <!-- Google Maps Embed -->
        <div class="w-full h-96 rounded-lg overflow-hidden shadow-lg">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.666890587185!2d106.82493731476891!3d-6.175392395528385!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764b12d%3A0x3d2ad6e1e0e9bcc8!2sMonumen%20Nasional!5e0!3m2!1sen!2sid!4v1642000000000!5m2!1sen!2sid" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>

    <!-- Informasi Kontak Section -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold mb-6">Informasi Kontak</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Telepon -->
            <div>
                <p class="text-gray-500 mb-2">Telepon</p>
                <a href="tel:+622155512234" class="text-lg font-semibold hover:text-orange-500 transition">
                    +62 21 555 1234
                </a>
            </div>

            <!-- Email -->
            <div>
                <p class="text-gray-500 mb-2">Email</p>
                <a href="mailto:info@kafenolimit.com" class="text-lg font-semibold hover:text-orange-500 transition">
                    info@kafenolimit.com
                </a>
            </div>
        </div>

        <!-- Jam Operasional -->
        <div>
            <p class="text-gray-500 mb-2">Jam Operasional</p>
            <p class="text-lg font-semibold">Senin - Minggu: 10.00 - 22.00</p>
        </div>
    </div>
</div>
@endsection
