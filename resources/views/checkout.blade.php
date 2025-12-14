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

        <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            {{-- LEFT --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- 1. ALAMAT PENGIRIMAN --}}
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-[#5F1D2A] mb-4">Alamat Pengiriman</h2>

                    <div class="space-y-4">
                        <input type="text" name="receiver_name" placeholder="Nama Penerima"
                            class="w-full border rounded-xl px-4 py-3">

                        <input type="text" name="phone" placeholder="Nomor HP"
                            class="w-full border rounded-xl px-4 py-3">

                        <textarea name="address" rows="3" placeholder="Alamat lengkap"
                            class="w-full border rounded-xl px-4 py-3"></textarea>
                    </div>
                </div>

                {{-- 2. TUJUAN & ONGKIR --}}
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-[#5F1D2A] mb-4">Pengiriman</h2>

                    {{-- Origin --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-1">Kota Asal</label>
                        <input type="text" value="Purwokerto (Default)"
                            class="w-full border rounded-xl px-4 py-3 bg-gray-100" disabled>
                    </div>

                    {{-- Destination --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-1">Kota Tujuan</label>
                        <select name="destination"
                            class="w-full border rounded-xl px-4 py-3">
                            <option value="">-- Pilih Kota Tujuan --</option>
                            {{-- DATA DARI API RAJAONGKIR --}}
                        </select>
                    </div>

                    {{-- Courier --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1">Kurir</label>
                        <select name="courier"
                            class="w-full border rounded-xl px-4 py-3">
                            <option value="">-- Pilih Kurir --</option>
                            <option value="jne">JNE</option>
                            <option value="pos">POS Indonesia</option>
                            <option value="tiki">TIKI</option>
                        </select>
                    </div>

                    {{-- Ongkir Result --}}
                    <div class="mt-4 p-4 bg-[#F8D9DF] rounded-xl text-[#5F1D2A]">
                        Ongkir akan dihitung otomatis
                    </div>
                </div>

                {{-- 3. METODE PEMBAYARAN --}}
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h2 class="text-xl font-bold text-[#5F1D2A] mb-4">Metode Pembayaran</h2>

                    <div class="space-y-3">
                        <label class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="transfer" checked>
                            <span>Transfer Bank (sementara)</span>
                        </label>

                        <label class="flex items-center gap-3 opacity-60">
                            <input type="radio" disabled>
                            <span>Payment Gateway (Coming Soon)</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="bg-white rounded-2xl shadow-md p-6 h-fit">
                <h2 class="text-xl font-bold text-[#5F1D2A] mb-4">Ringkasan Pesanan</h2>

                @foreach ($items as $item)
                    <div class="flex justify-between mb-2 text-sm">
                        <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                        <span>
                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach

                <hr class="my-4">

                <div class="flex justify-between text-sm">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>

                <div class="flex justify-between text-sm">
                    <span>Ongkir</span>
                    <span id="shipping-cost">Rp 0</span>
                </div>

                <div class="flex justify-between font-bold text-lg mt-4">
                    <span>Total</span>
                    <span id="total-price">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>

                <button
                    class="w-full mt-6 bg-[#5F1D2A] text-white py-3 rounded-xl hover:bg-[#4a1620] transition font-semibold">
                    Konfirmasi Pesanan
                </button>
            </div>
        </form>

    </div>
</div>

@endsection
