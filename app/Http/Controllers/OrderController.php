<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function detail(Order $order)
    {
        // Security: user hanya boleh lihat order miliknya
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('order', compact('order'));
    }

    public function create(Request $request, Product $product)
    {
        $validated = $request->validate([
            'receiver_name' => ['nullable', 'string', 'max:255'],
            'phone'         => ['nullable', 'string', 'max:20'],
            'address'       => ['nullable', 'string'],
            'subdistrict'   => ['nullable', 'string', 'max:100'],
            'district'      => ['nullable', 'string', 'max:100'],
            'city'          => ['nullable', 'string', 'max:100'],
            'zip_code'      => ['nullable', 'string', 'max:10'],
            'courier'       => ['nullable', 'string', 'max:50'],
            'shipping_cost' => ['nullable', 'integer', 'min:0'],
            'quantity'      => ['required', 'integer', 'min:1'],
        ]);

        // 🔒 Cek stok
        if ($product->stock < $validated['quantity']) {
            return redirect()->back()
                ->with('error', 'Stok tidak mencukupi');
        }

        DB::transaction(function () use ($validated, $product, &$order) {

            // Kurangi stok product
            $product->decrement('stock', $validated['quantity']);

            // Hitung harga
            $subtotal   = $product->price * $validated['quantity'];
            $totalPrice = $subtotal + ($validated['shipping_cost'] ?? 0);

            // Simpan order
            $order = Order::create([
                'user_id'       => Auth::id(),
                'receiver_name' => $validated['receiver_name'] ?? null,
                'phone'         => $validated['phone'] ?? null,
                'address'       => $validated['address'] ?? null,
                'subdistrict'   => $validated['subdistrict'] ?? null,
                'district'      => $validated['district'] ?? null,
                'city'          => $validated['city'] ?? null,
                'zip_code'      => $validated['zip_code'] ?? null,
                'courier'       => $validated['courier'] ?? null,
                'shipping_cost' => $validated['shipping_cost'] ?? 0,
                'total_price'   => $totalPrice,
                'status'        => 'pending',
            ]);

            // Simpan order item
            $order->items()->create([
                'product_id' => $product->id,
                'price'      => $product->price,
                'quantity'   => $validated['quantity'],
                'subtotal'   => $subtotal,
            ]);

            // ================= MIDTRANS =================
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id'     => $order->id,
                    'gross_amount' => (int) round($totalPrice), // WAJIB integer
                ],
                'customer_details' => [
                    'first_name' => $order->receiver_name,
                    'phone'      => $order->phone,
                ],
            ];

            $order->snap_token = \Midtrans\Snap::getSnapToken($params);
            $order->save();
        });

        return redirect()->route('show-payment', $order);
    }
    //untuk cart order
    public function store(Request $request)
    {
        // 1️⃣ VALIDASI DATA USER
        $validated = $request->validate([
            'receiver_name' => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string',
        ]);

        // 2️⃣ AMBIL CART ID DARI SESSION
        $cartIds = session('checkout_cart_ids');

        if (!$cartIds) {
            return redirect()->route('cart.index')
                ->with('error', 'Session checkout habis, silakan ulangi');
        }

        // 3️⃣ AMBIL CART DARI DATABASE
        $carts = Cart::with('product')
            ->whereIn('id', $cartIds)
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Produk tidak valid');
        }

        DB::beginTransaction();

        try {
            // 4️⃣ HITUNG TOTAL
            $totalPrice = 0;
            foreach ($carts as $cart) {
                $totalPrice += $cart->product->price * $cart->quantity;
            }

            // 5️⃣ BUAT ORDER
            $order = Order::create([
                'user_id'       => Auth::id(),
                'receiver_name' => $validated['receiver_name'],
                'phone'         => $validated['phone'],
                'address'       => $validated['address'],
                'total_price'   => $totalPrice,
                'status'        => 'pending',
            ]);

            // 6️⃣ BUAT ORDER ITEMS
            foreach ($carts as $cart) {
                $order->items()->create([
                    'product_id' => $cart->product->id,
                    'price'      => $cart->product->price,
                    'quantity'   => $cart->quantity,
                    'subtotal'   => $cart->product->price * $cart->quantity,
                ]);

                // OPTIONAL: hapus cart setelah masuk order
                $cart->delete();
            }

            // 7️⃣ MIDTRANS CONFIG
            \Midtrans\Config::$serverKey    = config('midtrans.serverKey');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized  = true;
            \Midtrans\Config::$is3ds        = true;

            $params = [
                'transaction_details' => [
                    'order_id'     => $order->id,
                    'gross_amount' => (int) $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => $order->receiver_name,
                    'phone'      => $order->phone,
                ],
            ];

            // 8️⃣ GENERATE SNAP TOKEN
            $order->snap_token = \Midtrans\Snap::getSnapToken($params);
            $order->save();

            // 9️⃣ CLEAR SESSION
            session()->forget('checkout_cart_ids');

            DB::commit();

            // 🔟 REDIRECT KE PAYMENT PAGE
            return redirect()->route('show-payment', $order);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal membuat order: ' . $e->getMessage());
        }
    }

    public function cancel(Order $order)
    {
        // Security: pastikan order milik user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Hapus item dulu (FK safety)
        $order->items()->delete();
        $order->delete();

        return redirect()->route('product');
    }
    public function success(Order $order)
    {
        // Security check
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->update([
            'status' => 'success'
        ]);

        return response()->json([
            'message' => 'Order berhasil diperbarui'
        ]);
    }
    public function prepare(Request $request)
    {
        $request->validate([
            'cart_ids' => 'required|array|min:1'
        ]);

        $cartIds = Cart::whereIn('id', $request->cart_ids)
            ->where('user_id', Auth::id())
            ->pluck('id')
            ->toArray();

        if (empty($cartIds)) {
            return back()->with('error', 'Pilih produk terlebih dahulu');
        }

        session([
            'checkout_cart_ids' => $cartIds
        ]);

        return redirect()->route('checkout.index');
    }
    public function index()
    {
        $cartIds = session('checkout_cart_ids');

        if (!$cartIds || empty($cartIds)) {
            return redirect()->route('cart.index')
                ->with('error', 'Session checkout habis, silakan pilih ulang');
        }

        $carts = Cart::with('product')
            ->whereIn('id', $cartIds)
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Produk tidak valid');
        }

        return view('product-checkout', compact('carts'));
    }
}
