@extends('section.layout')

@section('content')
    @if (session('error'))
        <div class="fixed top-6 right-6 z-50 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg animate-bounce"
            role="alert">
            {{ session('error') }}
        </div>
        <script>
            setTimeout(() => {
                const alert = document.querySelector('[role="alert"]');
                if (alert) alert.remove();
            }, 3000);
        </script>
    @endif

    @if ($errors->any())
        <div class="max-w-3xl mx-auto px-6 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
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
            <form action="{{ route('orders.store') }}" method="POST" class="bg-white rounded-xl shadow-md p-6 space-y-4">
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
                    {{-- Gabungan alamat lengkap untuk dikirim ke controller --}}
                    @php
                        $fullAddress = null;
                        if ($defaultAddress) {
                            $parts = [];
                            if ($defaultAddress->extra_detail) {
                                $parts[] = $defaultAddress->extra_detail;
                            }
                            if ($defaultAddress->subdistrict_name || $defaultAddress->district_name) {
                                $parts[] = trim(
                                    'Kel. ' .
                                        ($defaultAddress->subdistrict_name ?? '') .
                                        ', Kec. ' .
                                        ($defaultAddress->district_name ?? ''),
                                );
                            }
                            if ($defaultAddress->city_name || $defaultAddress->province_name) {
                                $parts[] = trim(
                                    ($defaultAddress->city_name ?? '') . ', ' . ($defaultAddress->province_name ?? ''),
                                );
                            }
                            if ($defaultAddress->postal_code) {
                                $parts[] = 'Kode Pos ' . $defaultAddress->postal_code;
                            }
                            $fullAddress = implode(', ', array_filter($parts));
                        } else {
                            $fullAddress = Auth::user()->address ?? null;
                        }
                    @endphp
                    <input type="hidden" id="address" name="address" value="{{ old('address', $fullAddress) }}">
                    <div id="selected-address-summary"
                        class="bg-[#FFF8F6] border border-[#B8A5A8]/30 rounded-lg px-4 py-3 text-[#5F1D2A]/80 space-y-1">
                        @if ($defaultAddress)
                            <div>
                                <span class="text-xs text-[#5F1D2A]/60">Nama Alamat</span>
                                <p class="font-semibold">{{ $defaultAddress->name }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-[#5F1D2A]/60">Alamat Jalan</span>
                                <p>{{ $defaultAddress->extra_detail }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-[#5F1D2A]/60">Kelurahan / Kecamatan</span>
                                <p>Kel. {{ $defaultAddress->subdistrict_name }}, Kec. {{ $defaultAddress->district_name }}
                                </p>
                            </div>
                            <div>
                                <span class="text-xs text-[#5F1D2A]/60">Kota / Provinsi</span>
                                <p>{{ $defaultAddress->city_name }}, {{ $defaultAddress->province_name }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-[#5F1D2A]/60">Kode Pos</span>
                                <p>{{ $defaultAddress->postal_code }}</p>
                            </div>
                        @else
                            <span class="italic text-[#5F1D2A]/50">Belum ada alamat</span>
                        @endif
                    </div>
                </div>

                <input type="hidden" name="subdistrict" value="{{ old('subdistrict', $defaultAddress?->subdistrict) }}">
                <input type="hidden" name="district" value="{{ old('district', $defaultAddress?->district) }}">
                <input type="hidden" name="city" value="{{ old('city', $defaultAddress?->city) }}">
                <input type="hidden" name="zip_code" value="{{ old('zip_code', $defaultAddress?->zip_code) }}">

                <!-- Tambahan: Hidden input untuk district_id dan weight agar validasi tidak error -->
                <!-- Hanya satu input hidden district_id, ambil dari $defaultAddress->district_id jika ada, jika tidak ke district -->
                <input type="hidden" id="district_id" name="district_id"
                    value="{{ old('district_id', $defaultAddress?->district_id ?? $defaultAddress?->district) }}">
                <input type="hidden" id="weight" name="weight"
                    value="{{ isset($carts) ? $carts->sum(fn($item) => ($item->product->weight ?? 0) * ($item->quantity ?? 1)) : $product->weight ?? 0 }}">

                <!-- Modal Pilih Alamat -->
                <div id="addressModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
                    <div class="flex items-center justify-center min-h-screen p-4">
                        <div class="bg-white rounded-xl shadow-xl max-w-md w-full">

                            {{-- Header --}}
                            <div class="px-6 py-4 border-b flex justify-between items-center">
                                <h3 class="text-lg font-bold text-[#5F1D2A]">
                                    Pilih Alamat
                                </h3>
                                <button onclick="closeAddressModal()" class="text-xl">&times;</button>
                            </div>

                            {{-- List alamat --}}
                            <div class="p-6 space-y-3 max-h-[60vh] overflow-y-auto">
                                @forelse ($addresses as $address)
                                    <button type="button" onclick='selectAddress(@json($address))'
                                        class="w-full text-left border rounded-lg px-4 py-3 transition {{ $address->is_default ? 'border-[#5F1D2A] bg-[#F8D9DF]' : 'border-gray-300 hover:bg-gray-50' }}">
                                        {{-- Nama alamat --}}
                                        <p class="font-semibold text-[#5F1D2A]">
                                            {{ $address->name }}
                                        </p>
                                        {{-- Detail jalan --}}
                                        <p class="text-sm text-[#5F1D2A]/80">
                                            {{ $address->extra_detail }}
                                        </p>
                                        {{-- Wilayah --}}
                                        <p class="text-sm text-[#5F1D2A]/70">
                                            Kel. {{ $address->subdistrict_name }},
                                            Kec. {{ $address->district_name }}
                                        </p>
                                        <p class="text-sm text-[#5F1D2A]/70">
                                            {{ $address->city_name }},
                                            {{ $address->province_name }}
                                        </p>
                                        {{-- Kode pos --}}
                                        <p class="text-xs text-[#5F1D2A]/50 mt-1">
                                            Kode Pos {{ $address->postal_code }}
                                        </p>
                                        {{-- Badge default --}}
                                        @if ($address->is_default)
                                            <span
                                                class="inline-block mt-2 text-xs font-semibold text-[#5F1D2A] bg-white border border-[#5F1D2A] px-2 py-0.5 rounded-full">
                                                Alamat Default
                                            </span>
                                        @endif
                                    </button>
                                @empty
                                    <p class="text-center text-sm text-gray-500">
                                        Belum ada alamat tersimpan
                                    </p>
                                @endforelse
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Radio Box Kurir -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kurir</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">

                        <div class="flex items-center">
                            <input type="radio" name="courier" id="courier-1" value="sicepat"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="courier-1" class="ml-2 block text-sm text-gray-900">SICEPAT</label>
                        </div>

                        <div class="flex items-center">
                            <input type="radio" name="courier" id="courier-2" value="jnt"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="courier-2" class="ml-2 block text-sm text-gray-900">J&T</label>
                        </div>

                        <div class="flex items-center">
                            <input type="radio" name="courier" id="courier-3" value="ninja"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="courier-3" class="ml-2 block text-sm text-gray-900">Ninja Express</label>
                        </div>

                        <div class="flex items-center">
                            <input type="radio" name="courier" id="courier-4" value="jne"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="courier-4" class="ml-2 block text-sm text-gray-900">JNE</label>
                        </div>

                        <div class="flex items-center">
                            <input type="radio" name="courier" id="courier-5" value="anteraja"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="courier-5" class="ml-2 block text-sm text-gray-900">Anteraja</label>
                        </div>

                        <div class="flex items-center">
                            <input type="radio" name="courier" id="courier-6" value="pos"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="courier-6" class="ml-2 block text-sm text-gray-900">POS Indonesia</label>
                        </div>

                        <div class="flex items-center">
                            <input type="radio" name="courier" id="courier-7" value="tiki"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="courier-7" class="ml-2 block text-sm text-gray-900">Tiki</label>
                        </div>

                        <div class="flex items-center">
                            <input type="radio" name="courier" id="courier-8" value="wahana"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="courier-8" class="ml-2 block text-sm text-gray-900">Wahana</label>
                        </div>

                        <div class="flex items-center">
                            <input type="radio" name="courier" id="courier-9" value="lion"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label for="courier-9" class="ml-2 block text-sm text-gray-900">Lion Parcel</label>
                        </div>

                    </div>
                </div>

                <div class="flex justify-center mb-8 flex-col items-center">
                    <button
                        class="btn-check w-full md:w-auto px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        Hitung Ongkos Kirim
                    </button>
                    <div class="loader mt-4" id="loading-indicator"></div>
                </div>


                <!-- Hasil Perhitungan Ongkos Kirim -->
                <div class="mt-8 p-6 bg-indigo-50 border border-indigo-200 rounded-lg results-container hidden">
                    <h2 class="text-xl font-semibold text-indigo-800 mb-2 text-center">Hasil Perhitungan Ongkos Kirim</h2>
                    <p class="text-xs text-indigo-700 mb-3 text-center" id="shipping-hint">
                        Pilih salah satu layanan pengiriman di bawah untuk melanjutkan pembayaran.
                    </p>

                    <!-- List opsi ongkir yang bisa dipilih -->
                    <div id="results-ongkir" class="space-y-3"></div>

                    <!-- Hidden field untuk dikirim ke controller -->
                    <input type="hidden" name="shipping_service" id="shipping_service">
                    <input type="hidden" name="shipping_cost" id="shipping_cost">
                    <input type="hidden" name="shipping_etd" id="shipping_etd">
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
        $(document).ready(function() {

            // Fungsi formatCurrency
            function formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(amount);
            }

            // ajax check ongkir
            let isProcessing = false;

            $('.btn-check').click(function(e) {
                e.preventDefault();

                if (isProcessing) return;


                let token = $("meta[name='csrf-token']").attr("content");
                // Ambil district_id dari hidden default address, bukan dari select
                let district_id = $('#district_id').val();
                let courier = $('input[name=courier]:checked').val();
                let weight = $('#weight').val();

                // Validasi form
                if (!district_id || !courier || !weight) {
                    alert('Harap lengkapi semua data terlebih dahulu!');
                    return;
                }

                isProcessing = true;

                // Tampilkan loading indicator
                $('#loading-indicator').show();
                $('.btn-check').prop('disabled', true);
                $('.btn-check').text('Memproses...');

                $.ajax({
                    url: "/check-ongkir",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        _token: token,
                        district_id: district_id,
                        courier: courier,
                        weight: weight,
                    },
                    beforeSend: function() {
                        // Sembunyikan hasil sebelumnya jika ada
                        $('.results-container').addClass('hidden').removeClass('block');
                    },
                    success: function(response) {
                        // kosongkan hasil lama & reset pilihan
                        $('#results-ongkir').empty();
                        $('#shipping_service').val('');
                        $('#shipping_cost').val('');
                        $('#shipping_etd').val('');

                        if (response && response.success && Array.isArray(response.data) &&
                            response.data.length) {
                            $('.results-container').removeClass('hidden').addClass('block');

                            $.each(response.data, function(index, value) {
                                const optionId = `shipping_option_${index}`;
                                $('#results-ongkir').append(`
                                            <label for="${optionId}" class="flex justify-between items-center p-3 bg-white rounded-xl shadow border border-gray-200 cursor-pointer hover:border-indigo-400 transition">
                                                <div class="flex items-center gap-3">
                                                    <input type="radio"
                                                           id="${optionId}"
                                                           name="shipping_option"
                                                           class="shipping-option h-4 w-4 text-indigo-600 border-gray-300"
                                                           data-service="${value.service} - ${value.description}"
                                                           data-etd="${value.etd}"
                                                           data-cost="${value.cost}">
                                                    <div>
                                                        <div class="text-sm font-semibold text-gray-800">${value.service} - ${value.description}</div>
                                                        <div class="text-xs text-gray-500">Estimasi: ${value.etd}</div>
                                                    </div>
                                                </div>
                                                <div class="text-base font-bold text-indigo-700">${formatCurrency(value.cost)}</div>
                                            </label>
                                        `);
                            });
                        } else {
                            const msg = (response && response.message) ?
                                response.message :
                                'Tidak ada data ongkir ditemukan.';

                            $('#results-ongkir').html(
                                `<div class="text-center text-red-500">${msg}</div>`);
                            $('.results-container').removeClass('hidden').addClass('block');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Gagal menghitung ongkir:", error);
                        $('#results-ongkir').html(
                            '<div class="text-center text-red-500">Terjadi kesalahan saat menghitung ongkir. Coba lagi.</div>'
                            );
                        $('.results-container').removeClass('hidden').addClass('block');
                    },
                    complete: function() {
                        // Sembunyikan loading indicator
                        $('#loading-indicator').hide();
                        $('.btn-check').prop('disabled', false);
                        $('.btn-check').text('Hitung Ongkos Kirim');

                        // pastikan tombol bisa diklik kembali
                        isProcessing = false;
                    }
                });
            });

            // Event: pilih salah satu opsi ongkir
            $(document).on('change', '.shipping-option', function() {
                const el = $(this);
                $('#shipping_service').val(el.data('service'));
                $('#shipping_cost').val(el.data('cost'));
                $('#shipping_etd').val(el.data('etd'));
            });

            function openAddressModal() {
                document.getElementById('addressModal').classList.remove('hidden');
            }

            function closeAddressModal() {
                document.getElementById('addressModal').classList.add('hidden');
            }

            function selectAddress(address) {
                // PATCH request to set as default
                fetch(`/address/${address.id}/set-default`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal mengatur alamat default');
                        return response.json().catch(() => ({}));
                    })
                    .then(data => {
                        window.location.reload();
                    })
                    .catch(error => {
                        alert(error.message);
                        closeAddressModal();
                    });
            }

        });
    </script>
@endsection
