<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /** Display a listing of the resource. */
    public function index()
    {
        $carts = Cart::all();
        return view('carts.index', compact('carts'));
    }

    /** Show the form for creating a new resource. */
    public function create()
    {
        return view('carts.create');
    }

    /** Store a newly created resource in storage. */
    public function store(Request $request)
    {
        // TODO: validate and persist
        return redirect()->route('carts.index')->with('success', 'Cart created (placeholder)');
    }

    /** Display the specified resource. */
    public function show(Cart $cart)
    {
        return view('carts.show', compact('cart'));
    }

    /** Show the form for editing the specified resource. */
    public function edit(Cart $cart)
    {
        return view('carts.edit', compact('cart'));
    }

    /** Update the specified resource in storage. */
    public function update(Request $request, Cart $cart)
    {
        // TODO: validate and update
        return redirect()->route('carts.index')->with('success', 'Cart updated (placeholder)');
    }

    /** Remove the specified resource from storage. */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect()->route('carts.index')->with('success', 'Cart deleted');
    }
}
