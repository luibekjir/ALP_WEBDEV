@extends('section.layout')

@section('content')

{{-- HEADER --}}
<div class="w-full bg-gradient-to-b from-[#F8D9DF] to-[#FFD6E0] py-14 text-center">
    <h1 class="text-4xl font-extrabold text-[#5F1D2A]">Keranjang Belanja</h1>
    <p class="mt-3 text-[#5F1D2A]/80">
        Periksa kembali produk sebelum melanjutkan ke checkout
    </p>
</div>

<div class="w-full bg-[#FFF8F6] min-h-screen">
    <div class="container mx-auto py-12 px-6">

        @if ($carts->isEmpty())
            <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                <h2 class="text-2xl font-bold text-[#5F1D2A]">Keranjang Kosong</h2>
                <a href="{{ route('product') }}"
                   class="inline-block mt-6 bg-[#5F1D2A] text-white px-6 py-3 rounded-xl">
                    Belanja Sekarang
                </a>
            </div>
        @else

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ================= LEFT: CART LIST ================= --}}
            <div class="lg:col-span-2 space-y-6">

                @foreach ($carts as $cart)
                    <div class="bg-white rounded-2xl shadow-md p-6 flex gap-4 items-start">

                        {{-- CHECKBOX (DIPAKAI OLEH FORM CHECKOUT DI KANAN) --}}
                        <input type="checkbox"
                               form="checkout-form"
                               name="cart_ids[]"
                               value="{{ $cart->id }}"
                               class="mt-2 w-5 h-5 checkout-checkbox"
                               data-subtotal="{{ $cart->product->price * $cart->quantity }}">

                        <div class="w-28 h-28 bg-[#F8D9DF] rounded-xl overflow-hidden">
                            @if ($cart->product->image_url)
                                <img src="{{ asset('storage/'.$cart->product->image_url) }}"
                                     class="w-full h-full object-cover">
                            @endif
                        </div>

                        <div class="flex-1">
                            <h3 class="font-bold text-[#5F1D2A]">{{ $cart->product->name }}</h3>
                            <p class="text-sm text-[#5F1D2A]/70">
                                Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                            </p>

                            {{-- ACTION BUTTONS (FORM SENDIRI) --}}
                            <div class="flex items-center gap-2 mt-3">

                                <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="px-3 py-1 bg-[#F8D9DF] rounded">−</button>
                                </form>

                                <span class="font-semibold">{{ $cart->quantity }}</span>

                                <form action="{{ route('cart.add', $cart->product_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-[#F8D9DF] rounded">+</button>
                                </form>

                                <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 text-sm">Hapus</button>
                                </form>
                            </div>
                        </div>

                        <div class="text-right min-w-[120px] font-bold text-[#5F1D2A]">
                            Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ================= RIGHT: CHECKOUT ================= --}}
            <form id="checkout-form"
                  action="{{ route('checkout.prepare') }}"
                  method="POST"
                  class="bg-white rounded-2xl shadow-md p-6 h-fit sticky top-28">
                @csrf

                <h3 class="text-xl font-bold text-[#5F1D2A] mb-4">Ringkasan</h3>

                <div class="border-t pt-4 flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span id="total-price">Rp 0</span>
                </div>

                <button type="submit"
                        class="w-full mt-6 bg-[#5F1D2A] text-white py-3 rounded-xl">
                    Lanjut ke Checkout
                </button>
            </form>

        </div>
        @endif
    </div>
</div>

{{-- TOTAL JS --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const checkboxes = document.querySelectorAll('.checkout-checkbox');
    const totalEl = document.getElementById('total-price');

    function updateTotal() {
        let total = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) total += Number(cb.dataset.subtotal);
        });
        totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
});

document.getElementById('checkout-form').addEventListener('submit', function (e) {
    const checked = document.querySelectorAll('.checkout-checkbox:checked');
    if (checked.length === 0) {
        e.preventDefault();
        alert('Pilih minimal 1 produk untuk checkout');
    }
});
</script>

@endsection
