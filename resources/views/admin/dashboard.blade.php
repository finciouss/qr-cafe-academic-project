@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <!-- Page Title -->
    <h1 class="text-4xl font-bold mb-8">Admin Dashboard</h1>

    <!-- Dashboard Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Menu Card -->
        <a href="{{ route('admin.menu') }}" class="block bg-gray-400 hover:bg-gray-500 rounded-xl p-8 text-white transition-all transform hover:scale-105">
            <div class="h-32 flex items-center justify-center mb-4">
                <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold mb-2">Menu</h3>
            <p class="text-white/80">Lihat dan kelola daftar menu</p>
        </a>

        <!-- Pesanan Card -->
        <a href="{{ route('admin.orders') }}" class="block bg-gray-400 hover:bg-gray-500 rounded-xl p-8 text-white transition-all transform hover:scale-105">
            <div class="h-32 flex items-center justify-center mb-4">
                <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold mb-2">Pesanan</h3>
            <p class="text-white/80">Lihat pesanan pelanggan secara realtime</p>
        </a>

        <!-- Riwayat Pesanan Card -->
        <a href="{{ route('admin.orders.history') }}" class="block bg-gray-400 hover:bg-gray-500 rounded-xl p-8 text-white transition-all transform hover:scale-105">
            <div class="h-32 flex items-center justify-center mb-4">
                <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold mb-2">Riwayat Pesanan</h3>
            <p class="text-white/80">Lihat riwayat transaksi</p>
        </a>
    </div>
</div>
@endsection
