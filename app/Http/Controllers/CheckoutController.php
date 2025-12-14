<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * TAMPILKAN HALAMAN CHECKOUT
     * (dari cart yang dicentang)
     */
    public function index(Request $request)
    {
        $request->validate([
            'cart_ids' => 'required|array|min:1',
        ], [
            'cart_ids.required' => 'Pilih minimal 1 produk untuk checkout.',
        ]);

        $items = Cart::with('product')
            ->where('user_id', Auth::id())
            ->whereIn('id', $request->cart_ids)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->withErrors('Cart tidak valid.');
        }

        $subtotal = $items->sum(fn ($cart) =>
            $cart->product->price * $cart->quantity
        );

        return view('checkout', compact('items', 'subtotal'));
    }

    /**
     * SIMPAN ORDER & ORDER ITEMS
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_name' => 'required',
            'phone'         => 'required',
            'address'       => 'required',
        ]);

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id'     => Auth::id(),
                'total_price' => 0, // nanti update setelah ongkir
                'status'      => 'pending',
            ]);

            DB::commit();

            return redirect()
                ->route('cart.index')
                ->with('success', 'Checkout berhasil! Pesanan sedang diproses.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'checkout' => 'Checkout gagal. Silakan coba lagi.',
            ]);
        }
    }
}
