<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Services\KomerceService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Terima cart_ids dari cart
     */
    public function prepare(Request $request)
    {
        $request->validate([
            'cart_ids' => 'required|array|min:1',
        ]);

        session(['checkout_cart_ids' => $request->cart_ids]);

        return redirect()->route('checkout.index');
    }

    /**
     * Tampilkan halaman checkout
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $addresses = $user->addresses;
        $defaultAddress = $addresses->where('is_default', true)->first();

        // ===== CHECKOUT DARI CART =====
        $carts = Cart::where('user_id', $user->id)
            ->with('product')
            ->get();

        if ($carts->count() > 0) {
            return view('product-checkout', compact(
                'carts',
                'addresses',
                'defaultAddress'
            ));
        }

        // ===== BUY NOW =====
        if ($request->has('product_id')) {
            $product = Product::findOrFail($request->product_id);

            return view('product-checkout', compact(
                'product',
                'addresses',
                'defaultAddress'
            ));
        }

        // ===== TIDAK ADA DATA =====
        return redirect()->route('cart.index')
            ->with('error', 'Tidak ada produk untuk checkout');
    }

    /**
     * Hitung ongkir via Komerce / RajaOngkir
     */
    public function shippingCost(Request $request, KomerceService $komerce)
    {
        $request->validate([
            'courier' => 'required',
        ]);

        $address = auth()->user()
            ->addresses()
            ->where('is_default', true)
            ->firstOrFail();

        $items = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $weight = $items->sum(fn ($c) => ($c->product->weight ?? 1000) * $c->quantity
        );

        $subtotal = $items->sum(fn ($c) => $c->product->price * $c->quantity
        );

        $response = $komerce->calculateDomesticCost([
            'origin_id' => 23, // kota toko
            'destination_id' => $address->destination_id,
            'weight' => $weight,
            'item_value' => $subtotal,
            'courier' => [$request->courier],
        ]);

        return response()->json($response);
    }

    /**
     * Simpan order
     */
    public function store(Request $request)
    {
        // nanti lanjut
    }
}
