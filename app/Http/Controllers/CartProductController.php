<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use Illuminate\Http\Request;

class CartProductController extends Controller
{
    public function index()
    {
        $items = CartProduct::all();
        return view('cart_products.index', compact('items'));
    }

    public function create()
    {
        return view('cart_products.create');
    }

    public function store(Request $request)
    {
        // TODO: validate and store
        return redirect()->route('cart_products.index')->with('success', 'CartProduct created (placeholder)');
    }

    public function show(CartProduct $cartProduct)
    {
        return view('cart_products.show', compact('cartProduct'));
    }

    public function edit(CartProduct $cartProduct)
    {
        return view('cart_products.edit', compact('cartProduct'));
    }

    public function update(Request $request, CartProduct $cartProduct)
    {
        // TODO: validate and update
        return redirect()->route('cart_products.index')->with('success', 'CartProduct updated (placeholder)');
    }

    public function destroy(CartProduct $cartProduct)
    {
        $cartProduct->delete();
        return redirect()->route('cart_products.index')->with('success', 'CartProduct deleted');
    }
}
