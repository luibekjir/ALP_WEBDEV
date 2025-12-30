@extends('section.layout')

@section('content')
<div class="w-full bg-[#FFF8F6] min-h-screen py-16">
    <div class="container mx-auto px-6 max-w-3xl">

        <h1 class="text-3xl font-bold text-[#5F1D2A] mb-8">
            Checkout
        </h1>

        {{-- PRODUK --}}
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex gap-4 items-center">
                <img src="{{ asset('storage/'.$product->image_url) }}"
                     class="w-24 h-24 object-cover rounded-lg border">

                <div class="flex-1">
                    <h3 class="font-bold text-[#5F1D2A]">
                        {{ $product->name }}
                    </h3>

                    <p class="text-[#5F1D2A]/70">
                        Harga:
                        <span id="price"
                              data-price="{{ $product->price }}">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- KUANTITAS --}}
            <div class="mt-4 flex items-center gap-4">
                <label class="font-semibold text-[#5F1D2A]">
                    Jumlah:
                </label>
                <input type="number"
                       name="quantity"
                       id="quantity"
                       min="1"
                       value="1"
                       class="w-24 border rounded-lg px-3 py-2 text-center">
            </div>

            {{-- SUBTOTAL --}}
            <div class="mt-4 text-right font-bold text-lg text-[#5F1D2A]">
                Subtotal:
                <span id="subtotal">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- FORM CHECKOUT --}}
        <form action="{{ route('create.order.buy-now', $product) }}"
              method="POST"
              class="bg-white rounded-xl shadow-md p-6 space-y-4">
            @csrf

            <input type="hidden" name="product_id" value="{{ $product->id }}">

            {{-- quantity disinkronkan via JS --}}
            <input type="hidden" name="quantity" id="quantity-hidden" value="1">

            <div>
                <label class="block font-semibold mb-1">Nama Penerima</label>
                <input type="text" name="receiver_name"
                       class="w-full border rounded-lg px-4 py-2"
                       value="{{ auth()->user()->name }}">
            </div>

            <div>
                <label class="block font-semibold mb-1">No. Telepon</label>
                <input type="text" name="phone"
                       class="w-full border rounded-lg px-4 py-2"
                       value="{{ auth()->user()->phone }}">
            </div>

            <div>
                <label class="block font-semibold mb-1">Alamat</label>
                <textarea name="address" rows="3"
                          class="w-full border rounded-lg px-4 py-2">{{ auth()->user()->address }}</textarea>
            </div>

            <button type="submit"
                    class="w-full mt-6 bg-[#5F1D2A] text-white py-3 rounded-lg font-bold">
                Lakukan Pembayaran
            </button>
        </form>

    </div>
</div>

{{-- ===================== --}}
{{-- JS HITUNG SUBTOTAL --}}
{{-- ===================== --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const qtyInput = document.getElementById('quantity');
    const qtyHidden = document.getElementById('quantity-hidden');
    const priceEl = document.getElementById('price');
    const subtotalEl = document.getElementById('subtotal');

    const price = parseInt(priceEl.dataset.price);

    function updateSubtotal() {
        let qty = parseInt(qtyInput.value);
        if (qty < 1) qty = 1;

        qtyInput.value = qty;
        qtyHidden.value = qty;

        const total = price * qty;
        subtotalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    qtyInput.addEventListener('input', updateSubtotal);
});
</script>
@endsection
