@extends('section.layout')

@section('content')
<div>
    {{-- HEADER --}}
    <div class="w-full bg-[#F8D9DF] py-14 text-center">
        <h1 class="text-4xl font-bold text-[#5F1D2A]">Cek Ongkir Pengiriman</h1>
        <p class="mt-3 text-[#5F1D2A]/70 max-w-2xl mx-auto px-4">
            Temukan estimasi biaya pengiriman Batik Bulau Sayang ke seluruh Indonesia.
        </p>
    </div>

    <div class="w-full bg-[#FFF8F6] min-h-screen">
        <div class="container mx-auto py-12 px-6">

            {{-- DESTINATION --}}
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-[#5F1D2A] mb-4">Tujuan Pengiriman</h2>

                <div class="bg-white rounded-2xl shadow-md p-6 space-y-4">
                    {{-- Search --}}
                    <input
                        type="text"
                        wire:model.debounce.500ms="keyword"
                        placeholder="Cari kode pos / kecamatan"
                        class="w-full border border-[#B8A5A8] rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5F1D2A]/50"
                    />

                    {{-- Select --}}
                    <select
                        wire:model="selectedDestination"
                        class="w-full border border-[#B8A5A8] rounded-xl px-4 py-3 text-[#5F1D2A] focus:ring-2 focus:ring-[#5F1D2A]/50">
                        <option value="">-- Pilih Tujuan --</option>

                        @forelse ($destinations as $destination)
                            <option value="{{ $destination['id'] }}">
                                {{ $destination['label'] }}
                            </option>
                        @empty
                            <option>Tidak ada data</option>
                        @endforelse
                    </select>
                </div>
            </div>

            {{-- LOADING --}}
            <div wire:loading class="text-center text-[#5F1D2A]/60 mb-10">
                Menghitung ongkir...
            </div>

            {{-- REGULER --}}
            @if (!empty($calculate_reguler))
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-[#5F1D2A] mb-6">Pengiriman Reguler</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($calculate_reguler as $item)
                        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-6">
                            <div class="flex justify-between mb-4">
                                <h3 class="font-bold text-[#5F1D2A]">{{ $item['shipping_name'] }}</h3>
                                <span class="text-xs bg-[#F8D9DF] px-3 py-1 rounded-full">
                                    {{ $item['service_name'] }}
                                </span>
                            </div>

                            <div class="text-sm text-[#5F1D2A]/70 space-y-1">
                                <p>Berat: {{ $item['weight'] }} kg</p>
                                <p>Estimasi: {{ $item['etd'] ?: '-' }}</p>
                                <p>COD: {{ $item['is_cod'] ? 'Ya' : 'Tidak' }}</p>
                            </div>

                            <div class="mt-4 pt-4 border-t">
                                <p class="text-xl font-bold text-[#5F1D2A]">
                                    Rp {{ number_format($item['shipping_cost_net'], 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- CARGO --}}
            @if (!empty($calculate_cargo))
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-[#5F1D2A] mb-6">Pengiriman Cargo</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($calculate_cargo as $item)
                        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-6">
                            <div class="flex justify-between mb-4">
                                <h3 class="font-bold text-[#5F1D2A]">{{ $item['shipping_name'] }}</h3>
                                <span class="text-xs bg-[#F8D9DF] px-3 py-1 rounded-full">
                                    {{ $item['service_name'] }}
                                </span>
                            </div>

                            <div class="text-sm text-[#5F1D2A]/70 space-y-1">
                                <p>Berat: {{ $item['weight'] }} kg</p>
                                <p>Estimasi: {{ $item['etd'] }}</p>
                            </div>

                            <div class="mt-4 pt-4 border-t">
                                <p class="text-xl font-bold text-[#5F1D2A]">
                                    Rp {{ number_format($item['shipping_cost_net'], 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- INSTANT --}}
            @if (!empty($calculate_instant))
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-[#5F1D2A] mb-6">Pengiriman Instan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($calculate_instant as $item)
                        <div class="bg-white rounded-2xl shadow-md border-2 border-[#5F1D2A]/20 p-6">
                            <h3 class="font-bold text-[#5F1D2A] mb-2">
                                {{ $item['shipping_name'] }} ({{ $item['service_name'] }})
                            </h3>

                            <p class="text-sm text-[#5F1D2A]/70">
                                Estimasi: {{ $item['etd'] }}
                            </p>

                            <p class="mt-4 text-xl font-bold text-[#5F1D2A]">
                                Rp {{ number_format($item['shipping_cost_net'], 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>


@endsection
