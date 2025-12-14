<div class="mb-10">
    <h2 class="text-2xl font-bold text-[#5F1D2A] mb-4">Tujuan Pengiriman</h2>

    <div class="relative bg-white rounded-2xl shadow-md p-6">
        <input
            type="text"
            wire:model.debounce.500ms="keyword"
            placeholder="Cari kode pos / kecamatan"
            class="w-full border border-[#B8A5A8] rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5F1D2A]/50"
        />

        {{-- DROPDOWN --}}
        @if ($showDropdown && count($destinations))
            <ul
                class="absolute z-50 w-[calc(100%-3rem)] mt-2 bg-white border border-[#B8A5A8] rounded-xl shadow-lg max-h-64 overflow-y-auto">

                @foreach ($destinations as $destination)
                    <li
                        wire:click="selectDestination('{{ $destination['id'] }}', '{{ $destination['label'] }}')"
                        class="px-4 py-3 cursor-pointer hover:bg-[#F8D9DF] text-sm text-[#5F1D2A]">
                        {{ $destination['label'] }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- selected --}}
    @if ($selectedDestination)
        <p class="mt-2 text-sm text-[#5F1D2A]/70">
            Tujuan dipilih ✔
        </p>
    @endif
</div>
