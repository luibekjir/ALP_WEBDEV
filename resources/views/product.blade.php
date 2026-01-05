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
            <div class="flex flex-col lg:flex-row gap-8">

                {{-- Button untuk membuka modal --}}
                @if (Auth::check() && Auth::user()->role === 'admin')
                    <div class="fixed bottom-8 right-8 z-50">
                        <button id="openProductModal"
                            class="bg-[#5F1D2A] text-white px-5 py-3 rounded-full shadow-lg hover:bg-[#4a1620] transition">
                            + Tambah Produk
                        </button>
                    </div>
                @endif
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
                            const alert = document.querySelector('[role="alert"]');
                            if (alert) alert.remove();
                        }, 3000);
                    </script>
                @endif
                {{-- Sidebar Kategori --}}
                {{-- <aside class="w-full lg:w-1/4">
                    <div class="bg-white border border-[#B8A5A8] p-6 rounded-xl shadow-sm sticky top-8">
                        {{-- <h3 class="text-xl font-semibold text-[#5F1D2A] mb-4 border-b border-[#B8A5A8]/30 pb-2">
                            Kategori
                        </h3>
                        <ul class="space-y-3 text-[#5F1D2A]/80">
                            <li><a href="#" class="hover:text-[#5F1D2A] hover:font-bold transition">Semua Koleksi</a>
                            </li>
                            <li><a href="#" class="hover:text-[#5F1D2A] hover:font-bold transition">Batik Tulis</a>
                            </li>
                            <li><a href="#" class="hover:text-[#5F1D2A] hover:font-bold transition">Batik Cap</a></li>
                            <li><a href="#" class="hover:text-[#5F1D2A] hover:font-bold transition">Kemeja Pria</a>
                            </li>
                            <li><a href="#" class="hover:text-[#5F1D2A] hover:font-bold transition">Dress Wanita</a>
                            </li>
                        </ul> 
                    </div>
                </aside> --}}

                {{-- Main Content --}}
                <main class="w-full lg:w-4/4 flex flex-col gap-6">

                    {{-- Sorting & Count --}}
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                        <p class="text-[#5F1D2A]/70 text-sm sm:text-base">
                            Menampilkan <span class="font-bold">{{ $products->count() }}</span> produk
                        </p>

                        {{-- <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-2">
                            <label for="sort" class="text-[#5F1D2A] font-medium">Urutkan:</label>
                            <select name="sort" id="sort" onchange="this.form.submit()"
                                class="border border-[#B8A5A8] rounded-lg px-3 py-2 text-[#5F1D2A] focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50 bg-white">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga
                                    Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga
                                    Tertinggi</option>
                                <option value="name_az" {{ request('sort') == 'name_az' ? 'selected' : '' }}>Nama (A-Z)
                                </option>
                                <option value="name_za" {{ request('sort') == 'name_za' ? 'selected' : '' }}>Nama (Z-A)
                                </option>
                            </select>
                        </form> --}}
                    </div>

                    {{-- Produk Grid --}}
                    @if ($products->isEmpty())
                        <div
                            class="flex flex-col items-center justify-center py-28 text-center bg-white border border-[#B8A5A8] border-dashed rounded-2xl">
                            <div class="text-[#5F1D2A]/40 text-7xl mb-4">☹</div>
                            <h2 class="text-3xl font-bold text-[#5F1D2A]">Belum ada Produk</h2>
                            <p class="text-[#5F1D2A]/60 mt-3 text-lg max-w-md">
                                Maaf, saat ini kami belum memiliki koleksi untuk kategori ini.
                            </p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                            @foreach ($products as $product)
                                <div
                                    class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full group relative">

                                    {{-- IMAGE --}}
                                    <div class="h-64 relative overflow-hidden rounded-t-2xl">
                                        @if ($product->image_url)
                                            <img src="{{ asset('storage/' . $product->image_url) }}"
                                                alt="{{ $product->name }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-[#F8D9DF]">
                                                <span class="text-[#5F1D2A]/40 font-medium">No Image</span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- CONTENT --}}
                                    <div class="p-5 flex flex-col flex-grow">

                                        {{-- CATEGORY --}}
                                        <span class="text-xs text-[#5F1D2A]/60 mb-1 uppercase tracking-wider">
                                            {{ $product->category->name ?? 'Batik' }}
                                        </span>

                                        {{-- NAME --}}
                                        <h3 class="text-lg font-bold text-[#5F1D2A] mb-1 line-clamp-2 leading-tight">
                                            {{ $product->name }}
                                        </h3>

                                        {{-- STOCK --}}
                                        <span class="text-sm text-[#5F1D2A]/80 mb-3">
                                            Stok: {{ $product->stock }}<br>
                                            Berat: {{ $product->weight ?? '-' }} gram<br>
                                            {{-- Rating: {{ $product->rating ?? '-' }}/5 --}}
                                        </span>

                                        {{-- FOOTER --}}
                                        <div class="mt-auto pt-4 border-t border-[#B8A5A8]/20">

                                            {{-- PRICE --}}
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="text-[#5F1D2A] font-bold text-lg">
                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </span>
                                            </div>

                                            {{-- USER ACTION --}}
                                            @auth
                                                <div class="flex gap-2 mb-3">

                                                    {{-- ADD TO CART --}}
                                                    @if ($product->stock > 0)
                                                        <form action="{{ route('cart.add', $product->id) }}" method="POST"
                                                            class="flex-1">
                                                            @csrf
                                                            <button type="submit"
                                                                class="w-full bg-[#5F1D2A] text-white py-2 rounded-lg hover:bg-[#4a1620] transition text-sm font-semibold">
                                                                + Keranjang
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button
                                                            class="flex-1 bg-gray-300 text-gray-500 py-2 rounded-lg cursor-not-allowed text-sm font-semibold"
                                                            disabled>
                                                            Stok Habis
                                                        </button>
                                                    @endif

                                                    {{-- BUY NOW --}}
                                                    {{-- @if ($product->stock > 0)
                                                        <form action="{{ route('checkout.buy-now', $product) }}" method="GET"
                                                            class="flex-1">
                                                            <button type="submit"
                                                                class="w-full bg-[#FFD6E0] text-[#5F1D2A] py-2 rounded-lg hover:bg-[#F8D9DF] transition text-sm font-semibold border border-[#5F1D2A]/30">
                                                                Beli
                                                            </button>
                                                        </form>
                                                    @endif --}}

                                                </div>
                                            @else
                                                <a href="{{ url('/login') }}"
                                                    class="block w-full text-center bg-gray-400 text-white py-2 rounded-lg font-semibold mb-3">
                                                    Login
                                                </a>
                                            @endauth

                                            {{-- ADMIN ACTION (BATAS GARIS BARU) --}}
                                            @if (Auth::check() && Auth::user()->role === 'admin')
                                                <div class="pt-3 border-t border-[#B8A5A8]/20 flex gap-2">
                                                    <button type="button" onclick="openEditModal(this)"
                                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                                        data-price="{{ $product->price }}"
                                                        data-stock="{{ $product->stock }}"
                                                        data-description="{{ $product->description }}"
                                                        data-category="{{ $product->category_id }}"
                                                        class="flex-1 px-3 py-2 text-sm bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition">
                                                        Edit
                                                    </button>

                                                    <form action="{{ route('product.destroy', $product->id) }}"
                                                        method="POST" class="flex-1"
                                                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            class="w-full px-3 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </main>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT PRODUCT --}}
    <div id="editProductModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 relative">
            <button onclick="closeEditModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                ✕
            </button>

            <h2 class="text-2xl font-bold text-[#5F1D2A] mb-4">Edit Produk</h2>

            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="category_id" id="edit-category">

                <div class="mb-3">
                    <label class="block text-sm font-medium">Nama</label>
                    <input type="text" name="name" id="edit-name" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Harga</label>
                    <input type="number" name="price" id="edit-price" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Stok</label>
                    <input type="number" name="stock" id="edit-stock" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Berat (gram)</label>
                    <input type="number" name="weight" id="edit-weight" class="w-full border rounded px-3 py-2"
                        min="0">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Rating</label>
                    <input type="number" name="rating" id="edit-rating" class="w-full border rounded px-3 py-2"
                        min="0" max="5" step="0.1">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Deskripsi</label>
                    <textarea name="description" id="edit-description" class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium">Gambar Baru (opsional)</label>
                    <input type="file" name="image" class="w-full border rounded px-3 py-2">
                </div>

                <button type="submit" class="w-full bg-[#5F1D2A] text-white py-2 rounded mt-4">
                    Update Produk
                </button>
            </form>
        </div>
    </div>

    {{-- Modal Create Product --}}
    <div id="createProductModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 relative">
            {{-- Close Button --}}
            <button id="closeProductModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <h2 class="text-2xl font-bold text-[#5F1D2A] mb-4">Tambah Produk Baru</h2>

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-[#5F1D2A]">Nama Produk</label>
                    <input type="text" name="name" id="name"
                        class="mt-1 block w-full border border-[#B8A5A8] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50"
                        required>
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-[#5F1D2A]">Kategori</label>
                    <select name="category_id" id="category_id"
                        class="mt-1 block w-full border border-[#B8A5A8] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-[#5F1D2A]">Harga</label>
                    <input type="number" name="price" id="price"
                        class="mt-1 block w-full border border-[#B8A5A8] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50"
                        required>
                </div>

                <div class="mb-4">
                    <label for="stock" class="block text-sm font-medium text-[#5F1D2A]">Stok</label>
                    <input type="number" name="stock" id="stock" value="0" min="0"
                        class="mt-1 block w-full border border-[#B8A5A8] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50"
                        required>
                </div>

                <div class="mb-4">
                    <label for="weight" class="block text-sm font-medium text-[#5F1D2A]">Berat (gram)</label>
                    <input type="number" name="weight" id="weight" value="0" min="0"
                        class="mt-1 block w-full border border-[#B8A5A8] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50">
                </div>

                <div class="mb-4">
                    <label for="rating" class="block text-sm font-medium text-[#5F1D2A]">Rating</label>
                    <input type="number" name="rating" id="rating" value="0" min="0" max="5"
                        step="0.1"
                        class="mt-1 block w-full border border-[#B8A5A8] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-[#5F1D2A]">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full border border-[#B8A5A8] rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50"></textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-[#5F1D2A]">Gambar Produk</label>
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
            const modal = document.getElementById('createProductModal');
            const openModalBtn = document.getElementById('openProductModal');
            const closeModalBtn = document.getElementById('closeProductModal');

            if (openModalBtn) {
                openModalBtn.addEventListener('click', () => modal.classList.remove('hidden'));
            }

            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', () => modal.classList.add('hidden'));
            }

            // Tutup modal jika klik di luar konten
            modal.addEventListener('click', (e) => {
                if (e.target === modal) modal.classList.add('hidden');
            });
        });

        // ================= EDIT MODAL =================
        function openEditModal(button) {
            const id = button.dataset.id;

            const form = document.getElementById('editProductForm');
            form.action = `/product/${id}`;

            document.getElementById('edit-name').value = button.dataset.name;
            document.getElementById('edit-price').value = button.dataset.price;
            document.getElementById('edit-stock').value = button.dataset.stock;
            document.getElementById('edit-description').value = button.dataset.description ?? '';
            document.getElementById('edit-category').value = button.dataset.category;
            document.getElementById('edit-weight').value = button.dataset.weight ?? '';
            document.getElementById('edit-rating').value = button.dataset.rating ?? '';

            document.getElementById('editProductModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editProductModal').classList.add('hidden');
        }
    </script>



@endsection
