<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('product', compact('products', 'categories'));
    }

    public function create()
    {
        return view('product');
    }

    public function store(Request $request)
    {
         $request->validate([
        'image' => 'nullable|image|max:2048',
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
        'stock' => 'required|numeric',
    ]);

    $product = new Product();
    $product->name = $request->name;
    $product->category_id = $request->category_id;
    $product->price = $request->price;
    $product->stock = $request->stock;
    $product->description = $request->description;

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $product->image_url = $path;
    }

    $product->save();

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer|exists:categories,id',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
