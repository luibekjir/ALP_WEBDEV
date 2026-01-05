<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function update(Request $request, Product $product)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            $validated['image_url'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('product')->with('success', 'Produk berhasil diperbarui');
    }



    public function destroy(Product $product)
    {
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus');
    }

    public function buyNow(Product $product)
    {
        $user = Auth::user();
        $defaultAddress = $user->defaultAddress;
        $addresses = $user->addresses;
        return view('buy-now-checkout', compact('product', 'defaultAddress', 'addresses'));
    }
}
