@extends('section.layout')

@section('content')

<div class="w-full bg-[#F8D9DF] py-14 text-center">
    <h1 class="text-4xl font-bold text-[#5F1D2A]">Acara Batik & Budaya</h1>
    <p class="mt-3 text-[#5F1D2A]/70 max-w-2xl mx-auto px-4">
        Temukan acara menarik yang menampilkan keindahan motif batik dan tradisi budaya.
    </p>
</div>

<div class="w-full bg-[#FFF8F6] min-h-screen">
    <div class="container mx-auto py-12 px-6">
        <main class="w-full">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                <p class="text-[#5F1D2A]/70">
                    Menampilkan <span class="font-bold">{{ $events->count() }}</span> acara
                </p>

                {{-- Tombol Tambah Acara --}}
                <button id="openEventModal"
                    class="bg-[#5F1D2A] text-white px-5 py-2 rounded-xl hover:bg-[#4a1620] transition font-semibold shadow-md hover:shadow-lg">
                    Tambah Acara
                </button>
            </div>

            @if ($events->isEmpty())
                <div
                    class="flex flex-col items-center justify-center py-20 text-center bg-white border border-[#B8A5A8]/50 border-dashed rounded-2xl">
                    <div class="text-[#5F1D2A]/40 text-6xl mb-4">☹</div>
                    <h2 class="text-2xl font-bold text-[#5F1D2A]">Belum ada Acara</h2>
                    <p class="text-[#5F1D2A]/60 mt-2">Maaf, saat ini kami belum memiliki acara yang tersedia.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-2 gap-8">
                    @foreach ($events as $event)
                        <div
                            class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden flex flex-col h-full group">

                            {{-- Image --}}
                            <div class="h-56 relative overflow-hidden rounded-t-2xl">
                                @if ($event->image_url)
                                    <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-[#F8D9DF]">
                                        <span class="text-[#5F1D2A]/40 font-medium">No Image</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-5 flex flex-col flex-grow">
                                <span class="text-xs text-[#5F1D2A]/60 mb-1 uppercase tracking-wider">
                                    {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('d M Y H:i') : 'Tanggal Tidak Tersedia' }}
                                </span>

                                <h3 class="text-lg font-bold text-[#5F1D2A] mb-2 line-clamp-2 leading-tight">
                                    {{ $event->title }}
                                </h3>

                                <p class="text-[#5F1D2A]/80 mb-4 line-clamp-3">
                                    {{ $event->description }}
                                </p>

                                <div class="mt-auto flex items-center justify-between pt-3 border-t border-[#B8A5A8]/20">
                                    <span class="text-[#5F1D2A] font-bold">
                                        @if ($event->price)
                                            Rp {{ number_format($event->price, 0, ',', '.') }}
                                        @else
                                            Gratis
                                        @endif
                                    </span>

                                    <button
                                        class="bg-[#5F1D2A] text-white px-4 py-2 rounded-xl hover:bg-[#4a1620] transition font-medium shadow-sm hover:shadow-md">
                                        Daftar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $events->links() }}
            </div>
        </main>
    </div>
</div>

{{-- Modal Create Event --}}
<div id="createEventModal"
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl w-11/12 md:w-1/2 lg:w-1/3 p-8 relative">

        {{-- Close Button --}}
        <button id="closeEventModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h2 class="text-2xl font-bold text-[#5F1D2A] mb-6 text-center">Tambah Acara Baru</h2>

        <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-[#5F1D2A]">Judul Acara</label>
                <input type="text" name="title" id="title" required
                    class="mt-1 block w-full border border-[#B8A5A8] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50 transition">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-[#5F1D2A]">Deskripsi</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full border border-[#B8A5A8] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50 transition"></textarea>
            </div>

            <div>
                <label for="date" class="block text-sm font-medium text-[#5F1D2A]">Tanggal & Waktu</label>
                <input type="datetime-local" name="date" id="date"
                    class="mt-1 block w-full border border-[#B8A5A8] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50 transition">
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-[#5F1D2A]">Harga (Opsional)</label>
                <input type="number" name="price" id="price"
                    class="mt-1 block w-full border border-[#B8A5A8] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50 transition">
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-[#5F1D2A]">Gambar Acara</label>
                <input type="file" name="image" id="image"
                    class="mt-1 block w-full text-sm text-[#5F1D2A]/70 border border-[#B8A5A8] rounded-lg cursor-pointer focus:outline-none">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-[#5F1D2A] text-white px-6 py-2 rounded-xl hover:bg-[#4a1620] transition font-semibold shadow-md hover:shadow-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script Toggle Modal --}}
<script>
    const createEventModal = document.getElementById('createEventModal');
    const openEventModalBtn = document.getElementById('openEventModal');
    const closeEventModalBtn = document.getElementById('closeEventModal');

    openEventModalBtn?.addEventListener('click', () => createEventModal.classList.remove('hidden'));
    closeEventModalBtn?.addEventListener('click', () => createEventModal.classList.add('hidden'));
    window.addEventListener('click', e => {
        if (e.target === createEventModal) createEventModal.classList.add('hidden');
    });
</script>

@endsection
