@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold">Manajemen Menu</h1>
        <a href="{{ route('admin.menu.create') }}" 
           class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-3 rounded-lg transition">
            Add Item
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    <!-- Search Bar -->
    <form action="{{ route('admin.menu') }}" method="GET" class="mb-6">
        <div class="relative">
            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" 
                   name="search" 
                   value="{{ $search }}"
                   placeholder="Search menu items..." 
                   class="w-full pl-12 pr-4 py-4 bg-gray-100 rounded-lg focus:outline-none focus:bg-white focus:ring-2 focus:ring-orange-500">
        </div>
    </form>

    <!-- Menu Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama Item</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Kategori</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Harga</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Ketersediaan</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <img src="{{ $product->image_url }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-12 h-12 rounded-lg object-cover">
                            <span class="font-medium">{{ $product->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $product->category->name }}</td>
                    <td class="px-6 py-4 font-semibold">{{ $product->formatted_price }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.menu.toggle', $product->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="px-4 py-2 rounded-lg font-medium {{ $product->is_available ? 'bg-gray-200 text-gray-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_available ? 'Available' : 'Unavailable' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.menu.edit', $product->id) }}" 
                               class="text-orange-600 hover:text-orange-800 font-medium">
                                Edit
                            </a>
                            <span class="text-gray-300">|</span>
                            <form action="{{ route('admin.menu.destroy', $product->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus menu ini?')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        Tidak ada menu tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
