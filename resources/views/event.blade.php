@extends('section.layout')

@section('content')
    {{-- ================= HEADER ================= --}}
    <div class="w-full bg-[#F8D9DF] py-14 text-center">
        <h1 class="text-4xl font-bold text-[#5F1D2A]">Acara Batik & Budaya</h1>
        <p class="mt-3 text-[#5F1D2A]/70 max-w-2xl mx-auto px-4">
            Temukan acara menarik yang menampilkan keindahan motif batik dan tradisi budaya.
        </p>
    </div>

    @if (session('success'))
        <div class="fixed top-6 right-6 z-50 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg animate-bounce"
            role="alert">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('[role="alert"]').remove();
            }, 3000);
        </script>
    @endif

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

    {{-- ================= CONTENT ================= --}}
    <div class="w-full bg-[#FFF8F6] min-h-screen">
        <div class="container mx-auto py-12 px-6">

            {{-- TOP BAR --}}
            <div class="flex justify-between items-center mb-6">
                <p class="text-[#5F1D2A]/70">
                    Menampilkan <span class="font-bold">{{ $events->count() }}</span> acara
                </p>

                @if (auth()->check() && auth()->user()->role === 'admin')
                    <button id="openCreateModal"
                        class="bg-[#5F1D2A] text-white px-5 py-2 rounded-xl hover:bg-[#4a1620] transition font-semibold shadow">
                        Tambah Acara
                    </button>
                @endif
            </div>

            {{-- GRID EVENT --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($events as $event)
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden flex flex-col">

                        {{-- IMAGE --}}
                        <div class="h-56 overflow-hidden">
                            @if ($event->image_url)
                                <img src="{{ asset('storage/' . $event->image_url) }}"
                                    class="w-full h-full object-cover hover:scale-105 transition">
                            @else
                                <div class="h-full flex items-center justify-center bg-[#F8D9DF] text-[#5F1D2A]/40">
                                    No Image
                                </div>
                            @endif
                        </div>

                        {{-- BODY --}}
                        <div class="p-5 flex flex-col flex-grow">
                            <span class="text-xs text-[#5F1D2A]/60 uppercase">
                                {{ \Carbon\Carbon::parse($event->start)->format('d M Y H:i') }}
                                —
                                {{ \Carbon\Carbon::parse($event->end)->format('d M Y H:i') }}
                            </span>

                            <h3 class="text-lg font-bold text-[#5F1D2A] mt-1">
                                {{ $event->title }}
                            </h3>

                            <p class="text-[#5F1D2A]/80 mt-2 line-clamp-3">
                                {{ $event->description }}
                            </p>

                            <div class="mt-auto pt-4 border-t border-[#B8A5A8]/20 flex justify-between items-center">
                                {{-- <span class="font-semibold text-[#5F1D2A]">Gratis</span> --}}

                                @if (auth()->user()->events->contains($event->id))
                                    <button class="btn btn-secondary font-semibold" disabled>Sudah Terdaftar</span>
                                    @else
                                        <form action="{{ route('event.register', $event) }}" method="POST">
                                            @csrf
                                        <button type="submit" class="bg-[#5F1D2A] text-white px-4 py-2 rounded-xl">
                                            Daftar & Tambah ke Calendar
                                        </button>
                                        </form>
                                @endif


                            </div>

                            {{-- ADMIN ACTION --}}
                            @if (auth()->check() && auth()->user()->role === 'admin')
                                <div class="pt-3 border-t border-[#B8A5A8]/20 flex gap-2">
                                    <button onclick="openEditModal(this)" data-id="{{ $event->id }}"
                                        data-title="{{ $event->title }}" data-description="{{ $event->description }}"
                                        data-start="{{ $event->start }}" data-end="{{ $event->end }}"
                                        class="flex-1 bg-yellow-400 text-white py-2 rounded-lg hover:bg-yellow-500">
                                        Edit
                                    </button>

                                    <form action="{{ route('event.destroy', $event) }}" method="POST"
                                        onsubmit="return confirm('Hapus acara ini?')" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">{{ $events->links() }}</div>
        </div>
    </div>

    {{-- ================= MODAL CREATE ================= --}}
    <div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl w-11/12 md:w-1/2 lg:w-1/3 p-6 relative">
            <button onclick="closeCreateModal()" class="absolute top-4 right-4">✕</button>

            <h2 class="text-xl font-bold text-[#5F1D2A] mb-4">Tambah Acara</h2>

            <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="text" name="title" placeholder="Judul" class="w-full mb-3 border rounded px-3 py-2"
                    required>

                <textarea name="description" placeholder="Deskripsi" class="w-full mb-3 border rounded px-3 py-2"></textarea>

                <label class="text-sm font-semibold text-[#5F1D2A]">Mulai</label>
                <input type="datetime-local" name="start" class="w-full mb-3 border rounded px-3 py-2" required>

                <label class="text-sm font-semibold text-[#5F1D2A]">Selesai</label>
                <input type="datetime-local" name="end" class="w-full mb-3 border rounded px-3 py-2" required>

                <input type="file" name="image" class="w-full mb-4 border rounded px-3 py-2">

                <button class="w-full bg-[#5F1D2A] text-white py-2 rounded-lg">
                    Simpan
                </button>
            </form>

        </div>
    </div>

    {{-- ================= MODAL EDIT ================= --}}
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl w-11/12 md:w-1/2 lg:w-1/3 p-6 relative">
            <button onclick="closeEditModal()" class="absolute top-4 right-4">✕</button>

            <h2 class="text-xl font-bold text-[#5F1D2A] mb-4">Edit Acara</h2>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="text" name="title" id="edit-title" class="w-full mb-3 border rounded px-3 py-2" required>

                <textarea name="description" id="edit-description" class="w-full mb-3 border rounded px-3 py-2"></textarea>

                <label class="text-sm font-semibold text-[#5F1D2A]">Mulai</label>
                <input type="datetime-local" name="start" id="edit-start" class="w-full mb-3 border rounded px-3 py-2"
                    required>

                <label class="text-sm font-semibold text-[#5F1D2A]">Selesai</label>
                <input type="datetime-local" name="end" id="edit-end" class="w-full mb-3 border rounded px-3 py-2"
                    required>


                <input type="file" name="image" class="w-full mb-4 border rounded px-3 py-2">

                <button class="w-full bg-[#5F1D2A] text-white py-2 rounded-lg">
                    Update
                </button>
            </form>
        </div>
    </div>

    {{-- ================= SCRIPT ================= --}}
    <script>
        const createModal = document.getElementById('createModal');
        const editModal = document.getElementById('editModal');

        document.getElementById('openCreateModal')?.addEventListener('click', () => {
            createModal.classList.remove('hidden');
        });

        function closeCreateModal() {
            createModal.classList.add('hidden');
        }

        function formatDateTimeLocal(dateStr) {
            const d = new Date(dateStr);
            return d.getFullYear() + '-' +
                String(d.getMonth() + 1).padStart(2, '0') + '-' +
                String(d.getDate()).padStart(2, '0') + 'T' +
                String(d.getHours()).padStart(2, '0') + ':' +
                String(d.getMinutes()).padStart(2, '0');
        }

        function openEditModal(btn) {
            document.getElementById('editForm').action = `/event/${btn.dataset.id}`;

            document.getElementById('edit-title').value = btn.dataset.title;
            document.getElementById('edit-description').value = btn.dataset.description;

            document.getElementById('edit-start').value = formatDateTimeLocal(btn.dataset.start);
            document.getElementById('edit-end').value = formatDateTimeLocal(btn.dataset.end);

            editModal.classList.remove('hidden');
        }

        function closeEditModal() {
            editModal.classList.add('hidden');
        }



        function closeEditModal() {
            editModal.classList.add('hidden');
        }
    </script>
@endsection
