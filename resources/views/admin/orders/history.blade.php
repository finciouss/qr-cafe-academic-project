@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold">Riwayat Pesanan</h1>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    <!-- Search & Filters -->
    <form action="{{ route('admin.orders.history') }}" method="GET" class="mb-6">
        <!-- Search Bar -->
        <div class="relative mb-4">
            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" 
                   name="search" 
                   value="{{ $search }}"
                   placeholder="Cari pesanan" 
                   class="w-full pl-12 pr-4 py-4 bg-gray-100 rounded-lg focus:outline-none focus:bg-white focus:ring-2 focus:ring-orange-500">
        </div>

        <!-- Filters -->
        <div class="flex gap-4">
            <!-- Filter Tanggal -->
            <input type="date" 
                   name="date" 
                   value="{{ $date }}"
                   class="px-4 py-3 bg-gray-100 rounded-lg focus:outline-none focus:bg-white focus:ring-2 focus:ring-orange-500">

            <!-- Filter Status -->
            <select name="status" 
                    class="px-4 py-3 bg-gray-100 rounded-lg focus:outline-none focus:bg-white focus:ring-2 focus:ring-orange-500">
                <option value="">Semua Status</option>
                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Diproses</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>

            <!-- Filter Metode Pembayaran -->
            <select name="payment_method" 
                    class="px-4 py-3 bg-gray-100 rounded-lg focus:outline-none focus:bg-white focus:ring-2 focus:ring-orange-500">
                <option value="">Semua Metode</option>
                <option value="Tunai" {{ $paymentMethod === 'Tunai' ? 'selected' : '' }}>Tunai</option>
                <option value="Kartu Kredit" {{ $paymentMethod === 'Kartu Kredit' ? 'selected' : '' }}>Kartu Kredit</option>
                <option value="Dompet Digital" {{ $paymentMethod === 'Dompet Digital' ? 'selected' : '' }}>Dompet Digital</option>
            </select>

            <!-- Submit Button -->
            <button type="submit" 
                    class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition">
                Filter
            </button>

            <!-- Reset Button -->
            @if($search || $status || $paymentMethod || $date)
            <a href="{{ route('admin.orders.history') }}" 
               class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition">
                Reset
            </a>
            @endif
        </div>
    </form>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">ID Pesanan</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Waktu</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Total</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Metode Pembayaran</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location='{{ route('admin.orders.show', $order->id) }}'">
                    <!-- ID Pesanan -->
                    <td class="px-6 py-4 font-semibold">#{{ $order->order_number }}</td>
                    
                    <!-- Tanggal -->
                    <td class="px-6 py-4 text-gray-600">{{ $order->created_at->format('Y-m-d') }}</td>
                    
                    <!-- Waktu -->
                    <td class="px-6 py-4 text-gray-600">{{ $order->created_at->format('H:i') }}</td>
                    
                    <!-- Status -->
                    <td class="px-6 py-4">
                        @if($order->status === 'pending')
                            <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg font-medium text-sm">
                                Pending
                            </span>
                        @elseif($order->status === 'processing')
                            <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg font-medium text-sm">
                                Diproses
                            </span>
                        @elseif($order->status === 'completed')
                            <span class="px-4 py-2 bg-green-100 text-green-800 rounded-lg font-medium text-sm">
                                Selesai
                            </span>
                        @else
                            <span class="px-4 py-2 bg-red-100 text-red-800 rounded-lg font-medium text-sm">
                                Dibatalkan
                            </span>
                        @endif
                    </td>
                    
                    <!-- Total -->
                    <td class="px-6 py-4 font-semibold text-gray-700">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    
                    <!-- Metode Pembayaran -->
                    <td class="px-6 py-4 text-gray-600">{{ $order->payment_method ?? 'Tunai' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        @if($search || $status || $paymentMethod || $date)
                            Tidak ada pesanan yang sesuai dengan filter
                        @else
                            Belum ada riwayat pesanan
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
    <div class="mt-6">
        {{ $orders->appends(request()->query())->links() }}
    </div>
    @endif

    <!-- Summary Info -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-600 mb-1">Total Pesanan</p>
            <p class="text-2xl font-bold">{{ $stats['total_orders'] }}</p>
        </div>
        <div class="bg-green-50 rounded-lg shadow p-4">
            <p class="text-sm text-green-600 mb-1">Pesanan Selesai</p>
            <p class="text-2xl font-bold text-green-800">{{ $stats['completed_orders'] }}</p>
        </div>
        <div class="bg-orange-50 rounded-lg shadow p-4">
            <p class="text-sm text-orange-600 mb-1">Total Pendapatan</p>
            <p class="text-2xl font-bold text-orange-800">
                Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
            </p>
        </div>
    </div>
</div>
@endsection
