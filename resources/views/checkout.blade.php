@extends('section.layout')

@section('content')
{{-- HEADER --}}
<div class="w-full bg-gradient-to-b from-[#F8D9DF] to-[#FFD6E0] py-14 text-center">
    <h1 class="text-4xl font-extrabold text-[#5F1D2A]">Checkout</h1>
    <p class="mt-3 text-[#5F1D2A]/80">
        Lengkapi data pengiriman dan pembayaran
    </p>
</div>

<div class="w-full bg-[#FFF8F6] min-h-screen">
    <div class="container mx-auto py-12 px-6">

        <form action="{{ route('checkout.confirm') }}" method="POST"
              class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            {{-- CART IDS --}}
            @foreach ($items as $item)
                <input type="hidden" name="cart_ids[]" value="{{ $item->id }}">
            @endforeach

            {{-- LEFT --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- DATA PENGIRIMAN --}}
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-[#5F1D2A]">Data Pengiriman</h2>
                        <button type="button" onclick="openAddressModal()"
                            class="text-sm font-semibold text-[#5F1D2A] underline">
                            Ganti Alamat
                        </button>
                    </div>

                    <div class="space-y-4">
                        <input name="receiver_name"
                            value="{{ old('receiver_name', $defaultAddress?->receiver_name) }}"
                            placeholder="Nama Penerima"
                            class="w-full border rounded-xl px-4 py-3">

                        <input name="phone"
                            value="{{ old('phone', $defaultAddress?->phone) }}"
                            placeholder="Nomor HP"
                            class="w-full border rounded-xl px-4 py-3">

                        <textarea name="address" rows="3"
                            placeholder="Alamat lengkap"
                            class="w-full border rounded-xl px-4 py-3">{{ old('address', $defaultAddress?->address) }}</textarea>

                        <div class="grid grid-cols-2 gap-4">
                            <input name="subdistrict"
                                value="{{ old('subdistrict', $defaultAddress?->subdistrict) }}"
                                placeholder="Kelurahan"
                                class="border rounded-xl px-4 py-3">

                            <input name="district"
                                value="{{ old('district', $defaultAddress?->district) }}"
                                placeholder="Kecamatan"
                                class="border rounded-xl px-4 py-3">
                        </div>

                        {{-- KOTA (AUTOCOMPLETE) --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="relative">
                                <input type="text" id="city_search"
                                    value="{{ old('city_name', $defaultAddress?->city_name) }}"
                                    placeholder="Ketik kota tujuan..."
                                    class="border rounded-xl px-4 py-3 w-full">

                                <input type="hidden" name="city_name"
                                    value="{{ old('city_name', $defaultAddress?->city_name) }}">

                                <input type="hidden" name="destination_id"
                                    value="{{ old('destination_id', $defaultAddress?->destination_id) }}">

                                <div id="city_result"
                                    class="absolute z-20 bg-white border rounded-xl mt-1 hidden w-full max-h-48 overflow-y-auto">
                                </div>
                            </div>

                            <input name="zip_code"
                                value="{{ old('zip_code', $defaultAddress?->zip_code) }}"
                                placeholder="Kode Pos"
                                class="border rounded-xl px-4 py-3">
                        </div>
                    </div>
                </div>

                {{-- PENGIRIMAN --}}
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4 text-[#5F1D2A]">Pengiriman</h2>

                    <select name="courier" id="courier"
                        class="w-full border rounded-xl px-4 py-3">
                        <option value="">-- Pilih Kurir --</option>
                        <option value="jne">JNE</option>
                        <option value="jnt">J&T</option>
                        <option value="sicepat">SiCepat</option>
                        <option value="pos">POS Indonesia</option>
                    </select>
                </div>

                {{-- PEMBAYARAN --}}
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4 text-[#5F1D2A]">Metode Pembayaran</h2>

                    <label class="flex gap-3">
                        <input type="radio" name="payment_method" value="transfer" checked>
                        Transfer Bank
                    </label>
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="bg-white rounded-2xl shadow-md p-6 h-fit">
                <h2 class="text-xl font-bold mb-4 text-[#5F1D2A]">Ringkasan Pesanan</h2>

                @foreach ($items as $item)
                    <div class="flex justify-between text-sm mb-2">
                        <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                        <span>
                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach

                <hr class="my-4">

                <div class="flex justify-between text-sm">
                    <span class="text-[#5F1D2A]/70">Subtotal</span>
                    <span id="subtotal">
                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between text-sm mt-2">
                    <span class="text-[#5F1D2A]/70">Ongkos Kirim</span>
                    <span id="shippingCost">-</span>
                </div>

                <hr class="my-4">

                <div class="flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span id="grandTotal">
                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                    </span>
                </div>

                <input type="hidden" name="shipping_cost" id="shipping_cost_input">

                <button type="submit"
                    id="confirmBtn"
                    disabled
                    class="w-full mt-6 bg-[#5F1D2A] text-white py-3 rounded-xl disabled:opacity-50">
                    Konfirmasi Pesanan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT --}}
<script>
const subtotal = {{ $subtotal }};
const csrf = '{{ csrf_token() }}';
const courierSelect = document.getElementById('courier');
const confirmBtn = document.getElementById('confirmBtn');

courierSelect.addEventListener('change', async function () {
    const courier = this.value;
    if (!courier) return;

    const res = await fetch('{{ route('checkout.shipping-cost') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({ courier })
    });

    const data = await res.json();

    // Ambil REGULER (paling umum)
    const service = data?.data?.calculate_reguler?.[0];

    if (!service) {
        alert('Ongkir tidak tersedia');
        return;
    }

    const shippingCost = service.shipping_cost_net;

    document.getElementById('shippingCost').innerText =
        'Rp ' + shippingCost.toLocaleString('id-ID');

    document.getElementById('grandTotal').innerText =
        'Rp ' + (subtotal + shippingCost).toLocaleString('id-ID');

    document.getElementById('shipping_cost_input').value = shippingCost;

    confirmBtn.disabled = false;
});
</script>
@endsection
