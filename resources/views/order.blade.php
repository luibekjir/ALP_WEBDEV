@extends('section.layout')

@section('content')

<div class="w-full bg-gradient-to-b from-[#F8D9DF] to-[#FFD6E0] py-14 text-center">
    <h1 class="text-3xl font-extrabold text-[#5F1D2A]">
        Detail Pesanan #{{ $order->id }}
    </h1>
    <p class="mt-2 text-[#5F1D2A]/70">
        Status: {{ ucfirst($order->status) }}
    </p>
</div>

<div class="container mx-auto py-12 px-6 max-w-4xl">

    {{-- ALAMAT --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="font-bold text-lg mb-3 text-[#5F1D2A]">Alamat Pengiriman</h2>
        <p>{{ $order->receiver_name }} ({{ $order->phone }})</p>
        <p>{{ $order->address }}</p>
        <p>
            {{ $order->subdistrict }},
            {{ $order->district }},
            {{ $order->city }},
            {{ $order->zip_code }}
        </p>
        <p class="mt-2">Kurir: {{ strtoupper($order->courier) }}</p>
    </div>

    {{-- ITEMS --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="font-bold text-lg mb-4 text-[#5F1D2A]">Produk</h2>

        @foreach ($order->items as $item)
            <div class="flex justify-between border-b py-2 text-sm">
                <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                <span>
                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                </span>
            </div>
        @endforeach
    </div>

    {{-- TOTAL --}}
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between font-bold text-lg">
            <span>Total</span>
            <span>
                Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </span>
        </div>

        <p class="mt-2 text-sm text-gray-500">
            Metode Pembayaran: {{ ucfirst($order->payment_method) }}
        </p>
    </div>

</div>

@endsection
