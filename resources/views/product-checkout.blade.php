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
                @if (!empty($carts) && $carts->count())
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

                    {{-- CASE 2: BUY NOW --}}
                @elseif (isset($product))
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
            <form action="{{ route('checkout.confirm') }}" method="POST"
                class="bg-white rounded-xl shadow-md p-6 space-y-4">
                @csrf

                {{-- Jika dari cart --}}
                @if (isset($carts))
                    @foreach ($carts as $item)
                        <input type="hidden" name="items[{{ $loop->index }}][product_id]"
                            value="{{ $item->product->id }}">
                        <input type="hidden" name="items[{{ $loop->index }}][quantity]" value="{{ $item->quantity }}">
                    @endforeach
                @else
                    {{-- Buy now --}}
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                @endif


                <div class="flex justify-between items-center mb-2">
                    <label class="block font-semibold text-[#5F1D2A] mb-1">Alamat Pengiriman</label>
                    <button type="button" onclick="openAddressModal()"
                        class="text-sm font-semibold text-[#5F1D2A] underline">Ganti Alamat</button>
                </div>

                <div>
                    <label class="block font-semibold text-[#5F1D2A] mb-1">Nama Penerima</label>
                    <input type="text" name="receiver_name" class="w-full border rounded-lg px-4 py-2"
                        value="{{ old('receiver_name', $defaultAddress?->receiver_name ?? Auth::user()->name) }}">
                </div>

                <div>
                    <label class="block font-semibold text-[#5F1D2A] mb-1">No. Telepon</label>
                    <input type="text" name="phone" class="w-full border rounded-lg px-4 py-2"
                        value="{{ old('phone', $defaultAddress?->phone ?? Auth::user()->phone) }}">
                </div>

                <div>
                    <label class="block font-semibold text-[#5F1D2A] mb-1">Alamat</label>
                    <textarea name="address" rows="3" class="w-full border rounded-lg px-4 py-2">{{ old('address', $defaultAddress?->address ?? Auth::user()->address) }}</textarea>
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
                                    <button type="button"
                                        class="w-full text-left border rounded-lg px-4 py-3 mb-2 {{ $address->is_default ? 'border-[#5F1D2A] bg-[#F8D9DF]' : 'border-gray-300 hover:bg-gray-50' }}"
                                        onclick="selectAddress(@json($address))">
                                        <p class="font-semibold text-[#5F1D2A]">{{ $address->address }}</p>
                                        <p class="text-sm text-[#5F1D2A]/70">{{ $address->district }},
                                            {{ $address->city }}</p>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full mt-6 bg-[#5F1D2A] text-white py-3 rounded-lg font-bold
                       hover:bg-[#4a1620] transition">
                    Lakukan Pembayaran
                </button>
            </form>

        </div>
    </div>
    <script>
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
