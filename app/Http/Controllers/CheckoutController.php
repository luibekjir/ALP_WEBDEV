<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Services\KomerceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

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

        // Ambil data provinsi dari Komerce/RajaOngkir API
        $provinces = [];
        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Accept' => 'application/json',
                'key' => config('services.komerce.key'),
            ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');
            if ($response->successful()) {
                $provinces = $response->json('data') ?? [];
            }
        } catch (\Exception $e) {
            $provinces = [];
        }

        // ===== CHECKOUT DARI CART (HANYA YANG DIPILIH) =====
        $cartIds = session('checkout_cart_ids');

        if (is_array($cartIds) && count($cartIds) > 0) {
            $carts = Cart::where('user_id', $user->id)
                ->whereIn('id', $cartIds)
                ->with('product')
                ->get();

            // Jika tidak ada cart yang cocok (misalnya sudah dihapus), kembalikan ke cart
            if ($carts->isEmpty()) {
                return redirect()->route('cart.index')
                    ->with('error', 'Produk yang dipilih tidak ditemukan di keranjang.');
            }

            return view('product-checkout', compact(
                'carts',
                'addresses',
                'defaultAddress',
                'provinces'
            ));
        }

        // ===== BUY NOW =====
        if ($request->has('product_id')) {
            $product = Product::findOrFail($request->product_id);

            return view('product-checkout', compact(
                'product',
                'addresses',
                'defaultAddress',
                'provinces'
            ));
        }

        // ===== TIDAK ADA DATA =====
        return redirect()->route('cart.index')
            ->with('error', 'Tidak ada produk untuk checkout');
    }

    /**
     * Hitung ongkir via Komerce / RajaOngkir
     */
    public function checkOngkir(Request $request)
    {
        try {
            $response = Http::asForm()->withHeaders([
                'Accept' => 'application/json',
                'key'    => config('services.komerce.key'),
            ])->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                'origin'      => 3855,
                'destination' => $request->input('district_id'),
                'weight'      => $request->input('weight'),
                'courier'     => $request->input('courier'),
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data'    => $response->json('data') ?? [],
                ]);
            }

            \Log::warning('RajaOngkir checkOngkir gagal', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Ekspedisi tidak tersedia untuk tujuan tersebut.',
            ], 200);
        } catch (\Throwable $e) {
            \Log::error('RajaOngkir checkOngkir exception', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server saat menghitung ongkir.',
            ], 200);
        }
    }


    /**
     * Konfirmasi checkout (checkout.confirm)
     */
    public function confirm(Request $request)
    {
        // Validasi input sesuai kebutuhan
        // Contoh validasi dasar:
        $validated = $request->validate([
            'receiver_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'courier' => 'required|string',
        ]);

        

        // Simpan order atau proses checkout di sini
        // Contoh: redirect ke halaman pembayaran dengan pesan sukses
        return redirect()->route('show-payment')->with('success', 'Checkout berhasil dikonfirmasi.');
    }

    /**
     * Simpan order
     */
    public function store(Request $request)
    {
        // nanti lanjut
    }
}
