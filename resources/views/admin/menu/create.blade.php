@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-12 max-w-3xl">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.menu') }}" class="text-orange-500 hover:text-orange-600 mb-4 inline-block">
            ← Kembali ke Manajemen Menu
        </a>
        <h1 class="text-4xl font-bold">Tambah Menu Baru</h1>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-8">
        @csrf

        <!-- Nama Item -->
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Nama Item</label>
            <input type="text" 
                   name="name" 
                   value="{{ old('name') }}"
                   placeholder="Contoh: Cappuccino"
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-orange-500"
                   required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kategori -->
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Kategori</label>
            <select name="category_id" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-orange-500"
                    required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Harga -->
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Harga</label>
            <input type="number" 
                   name="price" 
                   value="{{ old('price') }}"
                   placeholder="20000"
                   min="0"
                   step="1000"
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-orange-500"
                   required>
            @error('price')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Deskripsi
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Deskripsi (Opsional)</label>
            <textarea name="description" 
                      rows="3"
                      placeholder="Deskripsi singkat menu..."
                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-orange-500">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div> -->

        <!-- Upload Gambar -->
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Gambar Produk</label>
            <input type="file" 
                   name="image" 
                   accept="image/*"
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-orange-500">
            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF (Max: 2MB)</p>
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Ketersediaan -->
        <div class="mb-8">
            <label class="flex items-center">
                <input type="checkbox" 
                       name="is_available" 
                       value="1"
                       {{ old('is_available', true) ? 'checked' : '' }}
                       class="w-5 h-5 text-orange-500 rounded focus:ring-orange-500">
                <span class="ml-2 font-medium">Tersedia untuk dijual</span>
            </label>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
            <button type="submit" 
                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-lg transition">
                Simpan Menu
            </button>
            <a href="{{ route('admin.menu') }}" 
               class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 rounded-lg text-center transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
