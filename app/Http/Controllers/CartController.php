<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Tambah produk ke cart (tombol + / beli)
     */
    public function add(Product $product)
    {
        $userId = Auth::id();

        $cart = Cart::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id'    => $userId,
                'product_id' => $product->id,
                'quantity'   => 1,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    /**
     * Tampilkan halaman cart
     */
    public function index()
    {
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('cart', compact('carts'));
    }

    /**
     * Kurangi quantity (tombol −)
     */
    public function update(Cart $cart)
    {
        $this->authorizeCart($cart);

        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
        }

        return back();
    }

    /**
     * Hapus item cart
     */
    public function destroy(Cart $cart)
    {
        $this->authorizeCart($cart);

        $cart->delete();

        return back()->with('success', 'Produk dihapus dari keranjang');
    }

    /**
     * Helper: pastikan cart milik user login
     */
    private function authorizeCart(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan');
        }
    }
}
