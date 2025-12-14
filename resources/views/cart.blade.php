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

        {{-- Alert --}}
        @if (session('success'))
            <div class="mb-6 bg-green-100 text-green-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($carts->isEmpty())
            {{-- Empty --}}
            <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                <div class="text-6xl mb-4">🛒</div>
                <h2 class="text-2xl font-bold text-[#5F1D2A]">Keranjang Kosong</h2>
                <a href="/product"
                   class="inline-block mt-6 bg-[#5F1D2A] text-white px-6 py-3 rounded-xl">
                    Belanja Sekarang
                </a>
            </div>
        @else

        {{-- ===================== --}}
        {{-- CHECKOUT FORM (ONLY) --}}
        {{-- ===================== --}}
        <form id="checkout-form" action="{{ route('checkout.index') }}" method="POST">
            @csrf
        </form>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ===================== --}}
            {{-- CART LIST (LEFT) --}}
            {{-- ===================== --}}
            <div class="lg:col-span-2 space-y-6">

                @foreach ($carts as $cart)
                    <div class="bg-white rounded-2xl shadow-md p-6 flex gap-4 items-start">

                        {{-- CHECKBOX --}}
                        <input type="checkbox"
                               name="cart_ids[]"
                               value="{{ $cart->id }}"
                               form="checkout-form"
                               class="mt-2 w-5 h-5 text-[#5F1D2A]">

                        {{-- IMAGE --}}
                        <div class="w-28 h-28 bg-[#F8D9DF] rounded-xl overflow-hidden">
                            @if ($cart->product->image_url)
                                <img src="{{ asset('storage/'.$cart->product->image_url) }}"
                                     class="w-full h-full object-cover">
                            @endif
                        </div>

                        {{-- INFO --}}
                        <div class="flex-1">
                            <h3 class="font-bold text-[#5F1D2A]">
                                {{ $cart->product->name }}
                            </h3>

                            <p class="text-sm text-[#5F1D2A]/70">
                                Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                            </p>

                            {{-- QUANTITY --}}
                            <div class="flex items-center gap-2 mt-3">

                                {{-- MINUS --}}
                                <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-3 py-1 bg-[#F8D9DF] rounded">−</button>
                                </form>

                                <span class="font-semibold">{{ $cart->quantity }}</span>

                                {{-- PLUS --}}
                                <form action="{{ route('cart.add', $cart->product_id) }}" method="POST">
                                    @csrf
                                    <button class="px-3 py-1 bg-[#F8D9DF] rounded">+</button>
                                </form>

                                {{-- DELETE --}}
                                <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" class="ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 text-sm">Hapus</button>
                                </form>
                            </div>
                        </div>

                        {{-- SUBTOTAL --}}
                        <div class="text-right min-w-[120px]">
                            <p class="text-sm text-[#5F1D2A]/60">Subtotal</p>
                            <p class="font-bold text-[#5F1D2A]">
                                Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- ===================== --}}
            {{-- SUMMARY (RIGHT) --}}
            {{-- ===================== --}}
            <div class="bg-white rounded-2xl shadow-md p-6 h-fit sticky top-28">

                <h3 class="text-xl font-bold text-[#5F1D2A] mb-4">
                    Ringkasan
                </h3>

                <p class="text-sm text-[#5F1D2A]/60 mb-4">
                    * Total dihitung dari produk yang dipilih
                </p>

                <div class="border-t pt-4 flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span id="total-price">Rp 0</span>
                </div>

                <button type="submit"
                        form="checkout-form"
                        class="w-full mt-6 bg-[#5F1D2A] text-white py-3 rounded-xl">
                    Lanjut ke Checkout
                </button>

            </div>
        </div>
        @endif
    </div>
</div>

{{-- ===================== --}}
{{-- JS HITUNG TOTAL --}}
{{-- ===================== --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const checkboxes = document.querySelectorAll('input[name="cart_ids[]"]');
    const totalEl = document.getElementById('total-price');

    function updateTotal() {
        let total = 0;

        checkboxes.forEach(cb => {
            if (cb.checked) {
                const card = cb.closest('.bg-white');
                const subtotalText = card.querySelector('.text-right p.font-bold')
                    .innerText.replace(/[^\d]/g, '');
                total += parseInt(subtotalText);
            }
        });

        totalEl.innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
});
</script>

@endsection
