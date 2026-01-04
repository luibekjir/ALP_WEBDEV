<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Services\KomerceService;

class CheckoutController extends Controller
{
    /**
     * STEP 1: Terima cart_ids dari cart
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
     * STEP 2: Tampilkan halaman checkout
     */
    public function index()
    {
        $cartIds = session('checkout_cart_ids');

        if (!$cartIds) {
            return redirect()->route('cart.index')
                ->withErrors('Pilih produk terlebih dahulu.');
        }

        $items = Cart::with('product')
            ->where('user_id', Auth::id())
            ->whereIn('id', $cartIds)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $user = Auth::user();

        $subtotal = $items->sum(fn ($c) =>
            $c->product->price * $c->quantity
        );

        $defaultAddress = $user->addresses()
            ->where('is_default', true)
            ->first();

        $addresses = $user->addresses;

        return view('checkout', compact(
            'items',
            'subtotal',
            'user',
            'defaultAddress',
            'addresses'
        ));
    }

    /**
     * STEP 3: AJAX hitung ongkir (Komerce / RajaOngkir)
     */
    public function getShippingCost(
        Request $request,
        KomerceService $komerce
    ) {
        $request->validate([
            'courier' => 'required|string',
        ]);

        $address = auth()->user()
            ->addresses()
            ->where('is_default', true)
            ->firstOrFail();

        $weight = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get()
            ->sum(fn ($c) => ($c->product->weight ?? 1000) * $c->quantity);

        $subtotal = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get()
            ->sum(fn ($c) => $c->product->price * $c->quantity);

        $response = $komerce->calculateDomesticCost([
            'origin_id'      => 23, // ⚠️ ganti dengan kota asal tokomu
            'destination_id' => $address->destination_id,
            'weight'         => $weight,
            'item_value'     => $subtotal,
            'courier'        => [$request->courier],
        ]);

        return response()->json($response);
    }

    /**
     * STEP 4: Simpan order
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_name'  => 'required',
            'phone'          => 'required',
            'address'        => 'required',
            'payment_method' => 'required',
            'shipping_cost'  => 'required|numeric',
        ]);

        DB::transaction(function () use ($request) {
            $cartIds = session('checkout_cart_ids');

            $carts = Cart::with('product')
                ->where('user_id', auth()->id())
                ->whereIn('id', $cartIds)
                ->get();

            $subtotal = $carts->sum(fn ($c) =>
                $c->product->price * $c->quantity
            );

            $order = Order::create([
                'user_id'        => auth()->id(),
                'receiver_name'  => $request->receiver_name,
                'phone'          => $request->phone,
                'address'        => $request->address,
                'shipping_cost'  => $request->shipping_cost,
                'total_price'    => $subtotal + $request->shipping_cost,
                'payment_method' => $request->payment_method,
                'status'         => 'pending',
            ]);

            foreach ($carts as $cart) {
                $order->items()->create([
                    'product_id' => $cart->product_id,
                    'quantity'   => $cart->quantity,
                    'price'      => $cart->product->price,
                ]);
            }

            Cart::whereIn('id', $cartIds)->delete();
            session()->forget('checkout_cart_ids');
        });

        return redirect()->route('profile')
            ->with('success', 'Order berhasil dibuat!');
    }
}
