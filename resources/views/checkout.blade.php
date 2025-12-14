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

            {{-- kirim cart_ids --}}
            @foreach ($items as $item)
                <input type="hidden" name="cart_ids[]" value="{{ $item->id }}">
            @endforeach

            {{-- LEFT --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- ALAMAT PENGIRIMAN --}}
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4 text-[#5F1D2A]">Alamat Pengiriman</h2>

                    <div class="space-y-4">
                        <input name="receiver_name" placeholder="Nama Penerima"
                            class="w-full border rounded-xl px-4 py-3">

                        <input name="phone" placeholder="Nomor HP"
                            class="w-full border rounded-xl px-4 py-3">

                        <textarea name="address" rows="3"
                            placeholder="Alamat lengkap"
                            class="w-full border rounded-xl px-4 py-3"></textarea>

                        <div class="grid grid-cols-2 gap-4">
                            <input name="subdistrict" placeholder="Kelurahan"
                                class="border rounded-xl px-4 py-3">

                            <input name="district" placeholder="Kecamatan"
                                class="border rounded-xl px-4 py-3">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <input name="city" placeholder="Kota"
                                class="border rounded-xl px-4 py-3">

                            <input name="zip_code" placeholder="Kode Pos"
                                class="border rounded-xl px-4 py-3">
                        </div>
                    </div>
                </div>

                {{-- PENGIRIMAN --}}
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4 text-[#5F1D2A]">Pengiriman</h2>

                    <select name="courier"
                        class="w-full border rounded-xl px-4 py-3">
                        <option value="">-- Pilih Kurir --</option>
                        <option value="jne">JNE</option>
                        <option value="pos">POS Indonesia</option>
                        <option value="tiki">TIKI</option>
                    </select>
                </div>

                {{-- PEMBAYARAN --}}
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4 text-[#5F1D2A]">Metode Pembayaran</h2>

                    <label class="flex gap-3">
                        <input type="radio" name="payment_method"
                            value="transfer" checked>
                        Transfer Bank (sementara)
                    </label>
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="bg-white rounded-2xl shadow-md p-6 h-fit">
                <h2 class="text-xl font-bold mb-4 text-[#5F1D2A]">
                    Ringkasan Pesanan
                </h2>

                @foreach ($items as $item)
                    <div class="flex justify-between text-sm mb-2">
                        <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                        <span>
                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach

                <hr class="my-4">

                <div class="flex justify-between font-bold">
                    <span>Total</span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>

                <button class="w-full mt-6 bg-[#5F1D2A] text-white py-3 rounded-xl">
                    Konfirmasi Pesanan
                </button>
            </div>
        </form>

    </div>
</div>

@endsection
