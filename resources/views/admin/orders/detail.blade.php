@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-12 max-w-4xl">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.orders') }}" class="text-orange-500 hover:text-orange-600 mb-4 inline-block">
            ← Kembali ke Kelola Pesanan
        </a>
        <h1 class="text-4xl font-bold">Detail Pesanan #{{ $order->order_number }}</h1>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    <!-- Order Info -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Informasi Pesanan</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div>
                <p class="text-sm text-gray-500 mb-1">Nomor Pesanan</p>
                <p class="font-semibold">#{{ $order->order_number }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Waktu Pesanan</p>
                <p class="font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Status</p>
                <p class="font-semibold">
                    @if($order->status === 'pending')
                        <span class="text-gray-800">Baru</span>
                    @elseif($order->status === 'processing')
                        <span class="text-blue-600">Diproses</span>
                    @elseif($order->status === 'completed')
                        <span class="text-green-600">Selesai</span>
                    @else
                        <span class="text-red-600">Dibatalkan</span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Total</p>
                <p class="font-bold text-orange-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Customer Info -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Informasi Pelanggan</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-gray-500 mb-1">Nama Pemesan</p>
                <p class="font-semibold">{{ $order->customer_name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Nomor Meja</p>
                <p class="font-semibold">Meja {{ $order->table_number }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">WhatsApp</p>
                <p class="font-semibold">{{ $order->whatsapp }}</p>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Item Pesanan</h2>
        
        <div class="space-y-4">
            @foreach($order->items as $item)
            <div class="flex justify-between items-center pb-4 border-b last:border-0">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('storage/products/' . $item['image']) }}" 
                         alt="{{ $item['name'] }}" 
                         class="w-16 h-16 rounded-lg object-cover">
                    <div>
                        <p class="font-semibold">{{ $item['name'] }}</p>
                        <p class="text-sm text-gray-600">{{ $item['quantity'] }}x @ Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                    </div>
                </div>
                <p class="font-semibold">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>

        <!-- Total -->
        <div class="mt-6 pt-4 border-t">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Subtotal</span>
                <span class="font-semibold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($order->discount > 0)
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Diskon</span>
                <span class="font-semibold text-red-600">- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="flex justify-between items-center text-lg">
                <span class="font-bold">Total</span>
                <span class="font-bold text-orange-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-4">
        @if($order->status === 'pending')
            <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" 
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-lg transition">
                    Konfirmasi Pesanan
                </button>
            </form>
            <form action="{{ route('admin.orders.cancel', $order->id) }}" 
                  method="POST" 
                  onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')"
                  class="flex-1">
                @csrf
                <button type="submit" 
                        class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition">
                    Batalkan Pesanan
                </button>
            </form>
        @elseif($order->status === 'processing')
            <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-lg transition">
                    Selesaikan Pesanan
                </button>
            </form>
            <form action="{{ route('admin.orders.cancel', $order->id) }}" 
                  method="POST" 
                  onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')"
                  class="flex-1">
                @csrf
                <button type="submit" 
                        class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition">
                    Batalkan Pesanan
                </button>
            </form>
        @else
            <a href="{{ route('admin.orders') }}" 
               class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 rounded-lg text-center transition">
                Kembali ke Daftar Pesanan
            </a>
        @endif
    </div>
</div>
@endsection
