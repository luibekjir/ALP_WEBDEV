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

            {{-- Sidebar Kategori --}}
            <aside class="w-full lg:w-1/4">
                <div class="bg-white border border-[#B8A5A8] p-6 rounded-xl shadow-sm sticky top-8">
                    <h3 class="text-xl font-semibold text-[#5F1D2A] mb-4 border-b border-[#B8A5A8]/30 pb-2">
                        Kategori
                    </h3>
                    <ul class="space-y-3 text-[#5F1D2A]/80">
                        <li><a href="#" class="hover:text-[#5F1D2A] hover:font-bold transition">Semua Koleksi</a></li>
                        <li><a href="#" class="hover:text-[#5F1D2A] hover:font-bold transition">Batik Tulis</a></li>
                        <li><a href="#" class="hover:text-[#5F1D2A] hover:font-bold transition">Batik Cap</a></li>
                        <li><a href="#" class="hover:text-[#5F1D2A] hover:font-bold transition">Kemeja Pria</a></li>
                        <li><a href="#" class="hover:text-[#5F1D2A] hover:font-bold transition">Dress Wanita</a></li>
                    </ul>
                </div>
            </aside>

            {{-- Main Content --}}
            <main class="w-full lg:w-3/4 flex flex-col gap-6">

                {{-- Sorting & Count --}}
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <p class="text-[#5F1D2A]/70 text-sm sm:text-base">
                        Menampilkan <span class="font-bold">{{ $products->count() }}</span> produk
                    </p>

                    <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-2">
                        <label for="sort" class="text-[#5F1D2A] font-medium">Urutkan:</label>
                        <select name="sort" id="sort" onchange="this.form.submit()" 
                                class="border border-[#B8A5A8] rounded-lg px-3 py-2 text-[#5F1D2A] focus:outline-none focus:ring-2 focus:ring-[#5F1D2A]/50 bg-white">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="name_az" {{ request('sort') == 'name_az' ? 'selected' : '' }}>Nama (A-Z)</option>
                            <option value="name_za" {{ request('sort') == 'name_za' ? 'selected' : '' }}>Nama (Z-A)</option>
                        </select>
                    </form>
                </div>

                {{-- Produk Grid --}}
                @if($products->isEmpty())
                    <div class="flex flex-col items-center justify-center py-28 text-center bg-white border border-[#B8A5A8] border-dashed rounded-2xl">
                        <div class="text-[#5F1D2A]/40 text-7xl mb-4">☹</div>
                        <h2 class="text-3xl font-bold text-[#5F1D2A]">Belum ada Produk</h2>
                        <p class="text-[#5F1D2A]/60 mt-3 text-lg max-w-md">
                            Maaf, saat ini kami belum memiliki koleksi untuk kategori ini.
                        </p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                        @foreach($products as $product)
                            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden flex flex-col h-full group">

                                {{-- Image --}}
                                <div class="h-64 relative overflow-hidden rounded-t-2xl">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-[#F8D9DF]">
                                            <span class="text-[#5F1D2A]/40 font-medium">No Image</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Content --}}
                                <div class="p-5 flex flex-col flex-grow">
                                    <span class="text-xs text-[#5F1D2A]/60 mb-1 uppercase tracking-wider">
                                        {{ $product->category->name ?? 'Batik' }}
                                    </span>

                                    <h3 class="text-lg font-bold text-[#5F1D2A] mb-3 line-clamp-2 leading-tight">
                                        {{ $product->name }}
                                    </h3>

                                    <div class="mt-auto flex items-center justify-between pt-3 border-t border-[#B8A5A8]/20">
                                        <span class="text-[#5F1D2A] font-bold text-base">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                        <button class="bg-[#5F1D2A] text-white px-4 py-2 rounded-lg hover:bg-[#4a1620] transition font-semibold">
                                            Beli
                                        </button>
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

@endsection
