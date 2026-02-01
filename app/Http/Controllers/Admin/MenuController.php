<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
   
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->orderBy('category_id')
            ->orderBy('order')
            ->get();

        return view('admin.menu.index', compact('products', 'search'));
    }

  
    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.menu.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_available'] = $request->has('is_available');
        $validated['order'] = Product::where('category_id', $validated['category_id'])->max('order') + 1;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/products'), $imageName);
            $validated['image'] = $imageName;
        }

        Product::create($validated);

        return redirect()->route('admin.menu')->with('success', 'Menu berhasil ditambahkan');
    }

  
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::active()->get();
        return view('admin.menu.edit', compact('product', 'categories'));
    }

    
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_available'] = $request->has('is_available');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && file_exists(public_path('storage/products/' . $product->image))) {
                unlink(public_path('storage/products/' . $product->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/products'), $imageName);
            $validated['image'] = $imageName;
        }

        $product->update($validated);

        return redirect()->route('admin.menu')->with('success', 'Menu berhasil diperbarui');
    }

    
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image
        if ($product->image && file_exists(public_path('storage/products/' . $product->image))) {
            unlink(public_path('storage/products/' . $product->image));
        }

        $product->delete();

        return redirect()->route('admin.menu')->with('success', 'Menu berhasil dihapus');
    }

    
    public function toggleAvailability($id)
    {
        $product = Product::findOrFail($id);
        $product->is_available = !$product->is_available;
        $product->save();

        return back()->with('success', 'Status ketersediaan berhasil diubah');
    }
}
