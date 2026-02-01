@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold mb-2">Kelola Pesanan</h1>
        <p class="text-gray-600">Pantau dan kelola pesanan yang masuk secara real-time.</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nomor Pesanan</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Waktu Pesanan</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Detail</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <!-- Nomor Pesanan -->
                    <td class="px-6 py-4 font-semibold">#{{ $order->order_number }}</td>
                    
                    <!-- Waktu Pesanan -->
                    <td class="px-6 py-4 text-gray-600">
                        {{ $order->created_at->format('H:i A') }}
                    </td>
                    
                    <!-- Status -->
                    <td class="px-6 py-4">
                        @if($order->status === 'pending')
                            <span class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg font-medium">
                                Baru
                            </span>
                        @elseif($order->status === 'processing')
                            <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg font-medium">
                                Diproses
                            </span>
                        @elseif($order->status === 'completed')
                            <span class="px-4 py-2 bg-green-100 text-green-800 rounded-lg font-medium">
                                Selesai
                            </span>
                        @else
                            <span class="px-4 py-2 bg-red-100 text-red-800 rounded-lg font-medium">
                                Dibatalkan
                            </span>
                        @endif
                    </td>
                    
                    <!-- Detail -->
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                           class="text-gray-600 hover:text-orange-500 font-medium">
                            Lihat Detail
                        </a>
                    </td>
                    
                    <!-- Aksi -->
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            @if($order->status === 'pending')
                                <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-orange-600 hover:text-orange-800 font-medium">
                                        Konfirmasi
                                    </button>
                                </form>
                            @elseif($order->status === 'processing')
                                <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-green-600 hover:text-green-800 font-medium">
                                        Selesai
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="text-gray-600 hover:text-orange-500 font-medium">
                                    Lihat
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        Tidak ada pesanan aktif saat ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Info Card -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <p class="text-sm text-blue-800 font-medium">Total Pesanan Aktif: {{ $orders->count() }}</p>
                <p class="text-xs text-blue-600 mt-1">Halaman ini menampilkan pesanan dengan status "Baru" dan "Diproses"</p>
            </div>
        </div>
    </div>
</div>
@endsection
