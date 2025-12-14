@extends('section.layout')

@section('content')

    <div class="w-full bg-gradient-to-b from-[#F8D9DF] to-[#FFD6E0] py-16 text-center">
        <h1 class="text-5xl font-extrabold text-[#5F1D2A]">Koleksi Batik</h1>
        <p class="mt-4 text-[#5F1D2A]/80 max-w-3xl mx-auto px-4 text-lg">
            Temukan keindahan motif yang menceritakan kisah tradisi dalam balutan modernitas.
        </p>
    </div>

    <div class="w-full bg-[#FFF8F6] min-h-screen">
        <div class="container mx-auto py-16 px-6">


            
            {{-- Sorting & Count --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
                <p class="text-[#5F1D2A]/70 text-sm sm:text-base">
                    Menampilkan <span class="font-bold">{{ $gallery->count() }}</span> koleksi
                </p>

                @if (Auth::check() && Auth::user()->role === 'admin')
                    <div class="flex justify-end mb-6">
                        <button id="openCreateModal"
                            class="bg-[#5F1D2A] text-white px-4 py-2 rounded-lg hover:bg-[#4a1620] transition">
                            Tambah Koleksi Baru
                        </button>
                    </div>
                @endif
                <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-2">
                    <label for="sort" class="text-[#5F1D2A] font-medium">Urutkan:</label>
                    <select name="sort" id="sort" onchange="this.form.submit()"
                        class="border border-[#B8A5A8] rounded-lg px-3 py-2 text-[#5F1D2A] focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50 bg-white">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="name_az" {{ request('sort') == 'name_az' ? 'selected' : '' }}>Nama (A-Z)</option>
                        <option value="name_za" {{ request('sort') == 'name_za' ? 'selected' : '' }}>Nama (Z-A)</option>
                    </select>
                </form>
            </div>

            @if ($gallery->isEmpty())
                <div
                    class="flex flex-col items-center justify-center py-28 text-center bg-white border border-[#B8A5A8] border-dashed rounded-2xl">
                    <div class="text-[#5F1D2A]/40 text-7xl mb-4">☹</div>
                    <h2 class="text-3xl font-bold text-[#5F1D2A]">Belum ada Koleksi</h2>
                    <p class="text-[#5F1D2A]/60 mt-3 text-lg max-w-md">
                        Maaf, saat ini kami belum memiliki koleksi untuk kategori ini.
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach ($gallery as $item)
                        <div
                            class="bg-white rounded-2xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden flex flex-col h-full group cursor-pointer"
                            onclick="window.location.href='{{ route('gallery.show', $item->id) }}'">

                            {{-- Image --}}
                            <div class="h-64 relative overflow-hidden rounded-t-2xl">
                                @if ($item->image_url)
                                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->title }}"
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
                                    {{ $item->category ?? 'Batik' }}
                                </span>

                                <h3 class="text-lg font-bold text-[#5F1D2A] mb-3 line-clamp-2 leading-tight">
                                    {{ $item->title }}
                                </h3>

                                <p class="text-sm text-[#5F1D2A]/70 mb-4 line-clamp-3">
                                    {{ $item->description ?? 'Tidak ada deskripsi.' }}
                                </p>

                                {{-- Like & Comment Buttons --}}
                                <div class="mt-auto flex items-center justify-between pt-3 border-t border-[#B8A5A8]/20">
                                    <livewire:like-button :gallery="$item" :key="$item->id" />

                                    <button
                                        class="flex items-center gap-1 text-[#5F1D2A]/80 hover:text-[#5F1D2A] transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8s-9-3.582-9-8 4.03-8 9-8 9 3.582 9 8z" />
                                        </svg>
                                        Comment ({{ $item->comment_id ?? 0 }})
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Pagination --}}
            <div class="mt-12 flex justify-center">
                {{-- {{ $gallery->links() }} --}}
            </div>

            {{-- Modal Create Gallery --}}
            <div id="createGalleryModal"
                class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 relative">
                    <button id="closeCreateModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <h2 class="text-2xl font-bold text-[#5F1D2A] mb-4">Tambah Koleksi Baru</h2>
                    <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-[#5F1D2A]">Nama Koleksi</label>
                            <input type="text" name="name" id="name"
                                class="mt-1 block w-full border border-[#B8A5A8] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-[#5F1D2A]">Deskripsi</label>
                            <textarea name="description" id="description" rows="4"
                                class="mt-1 block w-full border border-[#B8A5A8] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-[#5F1D2A]">Gambar</label>
                            <input type="file" name="image" id="image"
                                class="mt-1 block w-full text-sm text-[#5F1D2A]/70 border border-[#B8A5A8] rounded-lg cursor-pointer focus:outline-none">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-[#5F1D2A] text-white px-4 py-2 rounded-lg hover:bg-[#4a1620] transition">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Modal Script --}}
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const modal = document.getElementById('createGalleryModal');
                    const closeModal = document.getElementById('closeCreateModal');
                    const openModalButton = document.getElementById('openCreateModal');

                    openModalButton.addEventListener('click', () => {
                        modal.classList.remove('hidden');
                    });

                    closeModal.addEventListener('click', () => {
                        modal.classList.add('hidden');
                    });

                    // Tutup modal jika klik di luar konten
                    modal.addEventListener('click', (e) => {
                        if (e.target === modal) {
                            modal.classList.add('hidden');
                        }
                    });
                });
            </script>

        @endsection
