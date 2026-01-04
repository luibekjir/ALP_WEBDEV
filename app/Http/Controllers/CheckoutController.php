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
     * TAMPILKAN CHECKOUT
     */
   public function prepare(Request $request)
    {
        $request->validate([
            'cart_ids' => 'required|array|min:1',
        ]);

        // simpan cart_ids ke session
        session(['checkout_cart_ids' => $request->cart_ids]);

        return redirect()->route('checkout.index');
    }

    /**
     * TAMPILKAN HALAMAN CHECKOUT (GET)
     */
    // public function index()
    // {
    //     $cartIds = session('checkout_cart_ids');

    //     if (!$cartIds) {
    //         return redirect()->route('cart.index')
    //             ->withErrors('Silakan pilih produk terlebih dahulu.');
    //     }

    //     $items = Cart::with('product')
    //         ->where('user_id', Auth::id())
    //         ->whereIn('id', $cartIds)
    //         ->get();

    //     if ($items->isEmpty()) {
    //         return redirect()->route('cart.index');
    //     }

    //     $subtotal = $items->sum(fn ($c) =>
    //         $c->product->price * $c->quantity
    //     );

    //     return view('product-checkout', compact('items', 'subtotal'));
    // }

    /**
     * SIMPAN ORDER
     */
    public function store(Request $request)
{
    $cartIds = session('checkout_cart_ids');

    if (!$cartIds) {
        return redirect()->route('cart.index');
    }

    $request->validate([
        'receiver_name' => 'required',
        'phone'         => 'required',
        'address'       => 'required',
        'subdistrict'   => 'required',
        'district'      => 'required',
        'city'          => 'required',
        'zip_code'      => 'required',
        'payment_method'=> 'required',
    ]);

    DB::beginTransaction();

    try {
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->whereIn('id', $cartIds)
            ->get();

        $subtotal = $carts->sum(fn ($c) =>
            $c->product->price * $c->quantity
        );

        $order = Order::create([
            'user_id'       => Auth::id(),
            'receiver_name' => $request->receiver_name,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'subdistrict'   => $request->subdistrict,
            'district'      => $request->district,
            'city'          => $request->city,
            'zip_code'      => $request->zip_code,
            'courier'       => $request->courier,
            'payment_method'=> $request->payment_method,
            'total_price'   => $subtotal,
            'status'        => 'pending',
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

        DB::commit();

        return redirect()->route('profile')
            ->with('success', 'Order berhasil dibuat!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors('Checkout gagal.');
    }
}

}
