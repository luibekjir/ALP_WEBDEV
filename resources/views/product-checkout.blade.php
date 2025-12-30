@extends('section.layout')

@section('content')
@if (session('error'))
    <div class="fixed top-6 right-6 z-50 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg animate-bounce"
        role="alert">
        {{ session('error') }}
    </div>
    <script>
        setTimeout(() => {
            document.querySelector('[role="alert"]').remove();
        }, 3000);
    </script>
@endif

<div class="w-full bg-[#FFF8F6] min-h-screen py-16">
    <div class="container mx-auto px-6 max-w-3xl">

        <h1 class="text-3xl font-bold text-[#5F1D2A] mb-8">
            Checkout
        </h1>

        {{-- ===================== --}}
        {{-- LIST PRODUK --}}
        {{-- ===================== --}}
        <div class="bg-white rounded-xl shadow-md p-6 mb-8 space-y-4">

            <h2 class="text-xl font-semibold text-[#5F1D2A] mb-4">
                Produk
            </h2>

            {{-- CASE 1: CHECKOUT DARI CART --}}
            @if (isset($carts))
                @foreach ($carts as $item)
                    <div class="flex gap-4 items-center border-b pb-4 last:border-b-0">
                        <img src="{{ asset('storage/' . $item->product->image_url) }}"
                             class="w-20 h-20 object-cover rounded-lg border">

                        <div class="flex-1">
                            <h3 class="font-bold text-[#5F1D2A]">
                                {{ $item->product->name }}
                            </h3>
                            <p class="text-sm text-[#5F1D2A]/70">
                                Qty: {{ $item->quantity }}
                            </p>
                        </div>

                        <span class="font-bold text-[#5F1D2A]">
                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach

            {{-- CASE 2: BUY NOW (1 PRODUK) --}}
            @else
                <div class="flex gap-4 items-center">
                    <img src="{{ asset('storage/' . $product->image_url) }}"
                         class="w-24 h-24 object-cover rounded-lg border">

                    <div>
                        <h3 class="font-bold text-[#5F1D2A]">
                            {{ $product->name }}
                        </h3>
                        <p class="text-[#5F1D2A]/70">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endif
        </div>

        {{-- ===================== --}}
        {{-- FORM CHECKOUT --}}
        {{-- ===================== --}}
        <form action="{{ route('checkout.confirm') }}"
              method="POST"
              class="bg-white rounded-xl shadow-md p-6 space-y-4">
            @csrf

            {{-- Jika dari cart --}}
            @if (isset($carts))
                @foreach ($carts as $item)
                    <input type="hidden" name="items[{{ $loop->index }}][product_id]"
                           value="{{ $item->product->id }}">
                    <input type="hidden" name="items[{{ $loop->index }}][quantity]"
                           value="{{ $item->quantity }}">
                @endforeach
            @else
                {{-- Buy now --}}
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
            @endif

            <div>
                <label class="block font-semibold text-[#5F1D2A] mb-1">Nama Penerima</label>
                <input type="text" name="receiver_name"
                       class="w-full border rounded-lg px-4 py-2"
                       value="{{ Auth::user()->name }}">
            </div>

            <div>
                <label class="block font-semibold text-[#5F1D2A] mb-1">No. Telepon</label>
                <input type="text" name="phone"
                       class="w-full border rounded-lg px-4 py-2"
                       value="{{ Auth::user()->phone }}">
            </div>

            <div>
                <label class="block font-semibold text-[#5F1D2A] mb-1">Alamat</label>
                <textarea name="address" rows="3"
                          class="w-full border rounded-lg px-4 py-2">{{ Auth::user()->address }}</textarea>
            </div>

            <button type="submit"
                class="w-full mt-6 bg-[#5F1D2A] text-white py-3 rounded-lg font-bold
                       hover:bg-[#4a1620] transition">
                Lakukan Pembayaran
            </button>
        </form>

    </div>
</div>
@endsection
