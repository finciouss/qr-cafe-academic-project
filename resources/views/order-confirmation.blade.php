@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-24">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('cart') }}" class="text-orange-500 hover:text-orange-600">← Pembayaran</a>
    </div>

    <h1 class="text-4xl font-bold mb-8">Konfirmasi Pesanan Anda</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Details -->
        <div class="lg:col-span-2">
            <!-- Detail Pesanan -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                <h2 class="text-xl font-bold mb-4">Detail Pesanan</h2>
                
                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Meja</p>
                        <p class="font-semibold">Meja {{ $orderData['table_number'] }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Waktu Pemesanan</p>
                        <p class="font-semibold">{{ now()->format('H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Nama Pemesan</p>
                        <p class="font-semibold">{{ $orderData['customer_name'] }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Perkiraan Waktu Selesai</p>
                        <p class="font-semibold">{{ now()->addMinutes(15)->format('H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Nomor WhatsApp</p>
                        <p class="font-semibold">{{ $orderData['whatsapp'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Item Pesanan -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h2 class="text-xl font-bold mb-4">Item Pesanan</h2>
                
                <div class="space-y-4">
                    @foreach($cart as $item)
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold">{{ $item['name'] }}</p>
                            <p class="text-gray-500 text-sm">{{ $item['quantity'] }}x</p>
                        </div>
                        <p class="font-semibold">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Ringkasan & Action -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-sm sticky top-24">
                <h2 class="text-xl font-bold mb-4">Ringkasan</h2>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total</span>
                        <span class="font-bold text-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <form action="{{ route('proceed.payment') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-4 rounded-lg transition">
                        Konfirmasi Pemesanan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
