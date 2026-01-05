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


            <div class="flex justify-between items-center mb-2">
                <label class="block font-semibold mb-1">Alamat Pengiriman</label>
                <button type="button" onclick="openAddressModal()" class="text-sm font-semibold text-[#5F1D2A] underline">Ganti Alamat</button>
            </div>

            <div>
                <label class="block font-semibold mb-1">Nama Penerima</label>
                <input type="text" name="receiver_name"
                       class="w-full border rounded-lg px-4 py-2"
                       value="{{ old('receiver_name', $defaultAddress?->receiver_name ?? auth()->user()->name) }}">
            </div>

            <div>
                <label class="block font-semibold mb-1">No. Telepon</label>
                <input type="text" name="phone"
                       class="w-full border rounded-lg px-4 py-2"
                       value="{{ old('phone', $defaultAddress?->phone ?? auth()->user()->phone) }}">
            </div>

            <div>
                <label class="block font-semibold mb-1">Alamat</label>
                <textarea name="address" rows="3"
                          class="w-full border rounded-lg px-4 py-2">{{ old('address', $defaultAddress?->address ?? auth()->user()->address) }}</textarea>
            </div>

            <input type="hidden" name="subdistrict" value="{{ old('subdistrict', $defaultAddress?->subdistrict) }}">
            <input type="hidden" name="district" value="{{ old('district', $defaultAddress?->district) }}">
            <input type="hidden" name="city" value="{{ old('city', $defaultAddress?->city) }}">
            <input type="hidden" name="zip_code" value="{{ old('zip_code', $defaultAddress?->zip_code) }}">

            <!-- Modal Pilih Alamat -->
            <div id="addressModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
                        <div class="px-6 py-4 border-b flex justify-between items-center">
                            <h3 class="text-lg font-bold text-[#5F1D2A]">Pilih Alamat</h3>
                            <button type="button" onclick="closeAddressModal()" class="text-xl">&times;</button>
                        </div>
                        <div class="p-6 space-y-3 max-h-[60vh] overflow-y-auto">
                            @foreach ($addresses as $address)
                                <button type="button" class="w-full text-left border rounded-lg px-4 py-3 mb-2 {{ $address->is_default ? 'border-[#5F1D2A] bg-[#F8D9DF]' : 'border-gray-300 hover:bg-gray-50' }}" onclick="selectAddress(@json($address))">
                                    <p class="font-semibold text-[#5F1D2A]">{{ $address->address }}</p>
                                    <p class="text-sm text-[#5F1D2A]/70">{{ $address->district }}, {{ $address->city }}</p>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
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

function openAddressModal() {
    document.getElementById('addressModal').classList.remove('hidden');
}
function closeAddressModal() {
    document.getElementById('addressModal').classList.add('hidden');
}
function selectAddress(address) {
    document.querySelector('input[name="receiver_name"]').value = address.receiver_name ?? '';
    document.querySelector('input[name="phone"]').value = address.phone ?? '';
    document.querySelector('textarea[name="address"]').value = address.address ?? '';
    document.querySelector('input[name="subdistrict"]').value = address.subdistrict ?? '';
    document.querySelector('input[name="district"]').value = address.district ?? '';
    document.querySelector('input[name="city"]').value = address.city ?? '';
    document.querySelector('input[name="zip_code"]').value = address.zip_code ?? '';
    closeAddressModal();
}
</script>
@endsection
