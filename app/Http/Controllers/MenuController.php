<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
   
    public function index(Request $request)
    {
        $categories = Category::active()->withCount('products')->get();
        
        $selectedCategory = $request->get('category', 'all');
        
        $products = Product::available()
            ->with('category')
            ->when($selectedCategory !== 'all', function ($query) use ($selectedCategory) {
                $query->whereHas('category', function ($q) use ($selectedCategory) {
                    $q->where('slug', $selectedCategory);
                });
            })
            ->orderBy('category_id')
            ->orderBy('order')
            ->get()
            ->groupBy('category.name');

        return view('menu', compact('categories', 'products', 'selectedCategory'));
    }
}
