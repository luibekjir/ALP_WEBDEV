@extends('section.layout')

@section('content')

{{-- HEADER --}}
<div class="w-full bg-gradient-to-b from-[#F8D9DF] to-[#FFD6E0] py-16 text-center">
    <h1 class="text-5xl font-extrabold text-[#5F1D2A]">Koleksi Batik</h1>
    <p class="mt-4 text-[#5F1D2A]/80 max-w-3xl mx-auto px-4 text-lg">
        Temukan keindahan motif yang menceritakan kisah tradisi dalam balutan modernitas.
    </p>
</div>

<div class="w-full bg-[#FFF8F6] min-h-screen">
    <div class="container mx-auto py-16 px-6">

        {{-- ADMIN: TAMBAH GALERI (TIDAK DIHAPUS) --}}
        @if (Auth::check() && Auth::user()->role === 'admin')
            <div class="flex justify-end mb-8">
                <button id="openCreateModal"
                    class="bg-[#5F1D2A] text-white px-5 py-2 rounded-lg hover:bg-[#4a1620]">
                    + Tambah Koleksi
                </button>
            </div>
        @endif

        {{-- GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

            @foreach ($gallery as $item)
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition flex flex-col">

                    {{-- IMAGE --}}
                    <div class="h-64 overflow-hidden">
                        @if ($item->image_url)
                            <img src="{{ asset('storage/'.$item->image_url) }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-[#F8D9DF]">
                                <span class="text-[#5F1D2A]/40">No Image</span>
                            </div>
                        @endif
                    </div>

                    {{-- CONTENT --}}
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold text-[#5F1D2A] mb-2">
                            {{ $item->title }}
                        </h3>

                        <p class="text-sm text-[#5F1D2A]/70 mb-4 line-clamp-3">
                            {{ $item->description }}
                        </p>

                        {{-- LIKE & COMMENT (JANGAN DIHAPUS) --}}
                        <div class="mt-auto pt-3 border-t flex justify-between items-center">
                            <livewire:like-button :gallery="$item" :key="'like-'.$item->id" />

                            <a href="{{ route('gallery.show', $item->id) }}"
                               class="text-[#5F1D2A]/80 hover:text-[#5F1D2A]">
                                💬 Comment
                            </a>
                        </div>

                        {{-- ADMIN ACTION --}}
                        @if (Auth::check() && Auth::user()->role === 'admin')
                            <div class="flex gap-2 mt-4">
                                <button onclick="openEditModal({{ $item->id }})"
                                    class="flex-1 bg-blue-500 text-white py-2 rounded-lg text-sm">
                                    Edit
                                </button>

                                <form action="{{ route('gallery.destroy', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus koleksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- MODAL EDIT --}}
                @if (Auth::check() && Auth::user()->role === 'admin')
                <div id="editModal-{{ $item->id }}"
                     class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-xl w-full max-w-md p-6 relative">
                        <button onclick="closeEditModal({{ $item->id }})"
                                class="absolute top-3 right-4 text-xl">&times;</button>

                        <h2 class="text-xl font-bold mb-4">Edit Koleksi</h2>

                        <form action="{{ route('gallery.update', $item->id) }}"
                              method="POST"
                              enctype="multipart/form-data"
                              class="space-y-4">
                            @csrf
                            @method('PUT')

                            <input type="text" name="title"
                                   value="{{ $item->title }}"
                                   class="w-full border rounded-lg px-3 py-2">

                            <textarea name="description" rows="3"
                                      class="w-full border rounded-lg px-3 py-2">{{ $item->description }}</textarea>

                            <input type="file" name="image"
                                   class="w-full border rounded-lg px-3 py-2">

                            <button type="submit"
                                    class="w-full bg-[#5F1D2A] text-white py-2 rounded-lg">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

@if (Auth::check() && Auth::user()->role === 'admin')
<div id="createGalleryModal"
     class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl w-full max-w-md p-6 relative">
        <button id="closeCreateModal"
                class="absolute top-3 right-4 text-xl">&times;</button>

        <h2 class="text-xl font-bold mb-4">Tambah Koleksi Baru</h2>

        <form action="{{ route('gallery.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-4">
            @csrf

            <input type="text" name="title"
                   placeholder="Judul"
                   class="w-full border rounded-lg px-3 py-2" required>

            <textarea name="description"
                      placeholder="Deskripsi"
                      rows="3"
                      class="w-full border rounded-lg px-3 py-2"></textarea>

            <input type="file" name="image"
                   class="w-full border rounded-lg px-3 py-2" required>

            <button type="submit"
                    class="w-full bg-[#5F1D2A] text-white py-2 rounded-lg">
                Simpan
            </button>
        </form>
    </div>
</div>
@endif

{{-- SCRIPT --}}
<script>
    const openCreate = document.getElementById('openCreateModal');
    const closeCreate = document.getElementById('closeCreateModal');
    const createModal = document.getElementById('createGalleryModal');

    openCreate?.addEventListener('click', () => createModal.classList.remove('hidden'));
    closeCreate?.addEventListener('click', () => createModal.classList.add('hidden'));

    function openEditModal(id) {
        document.getElementById('editModal-' + id).classList.remove('hidden');
    }
    function closeEditModal(id) {
        document.getElementById('editModal-' + id).classList.add('hidden');
    }
</script>

@endsection
