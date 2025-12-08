@extends('section.layout')

@section('content')

<div class="w-full bg-[#F8D9DF] py-14 text-center">
    <h1 class="text-4xl font-bold text-[#5F1D2A]">Koleksi Batik</h1>
    <p class="mt-3 text-[#5F1D2A]/70 max-w-2xl mx-auto px-4">
        Temukan keindahan motif yang menceritakan kisah tradisi dalam balutan modernitas.
    </p>
</div>

<div class="w-full bg-[#FFF8F6] min-h-screen">
    <div class="container mx-auto py-12 px-6">
        
        <div class="flex flex-col lg:flex-row gap-8">

            <aside class="w-full lg:w-1/4">
                <div class="bg-white border border-[#B8A5A8] p-6 rounded-xl shadow-sm sticky top-8">
                    <h3 class="text-xl font-semibold text-[#5F1D2A] mb-4 border-b border-[#B8A5A8]/30 pb-2">
                        Kategori
                    </h3>
                    <ul class="space-y-3 text-[#5F1D2A]/80">
                        <li>
                            <a href="#" class="hover:text-[#5F1D2A] hover:font-bold transition">Semua Koleksi</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-[#5F1D2A] hover:font-bold transition">Batik Tulis</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-[#5F1D2A] hover:font-bold transition">Batik Cap</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-[#5F1D2A] hover:font-bold transition">Kemeja Pria</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-[#5F1D2A] hover:font-bold transition">Dress Wanita</a>
                        </li>
                    </ul>
                </div>
            </aside>

            <main class="w-full lg:w-3/4">
                
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <p class="text-[#5F1D2A]/70">
                        Menampilkan <span class="font-bold">{{ $products->count() }}</span> produk
                    </p>
                </div>

                @if($products->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 text-center bg-white border border-[#B8A5A8] border-dashed rounded-xl">
                        <div class="text-[#5F1D2A]/40 text-6xl mb-4">☹</div> 
                        <h2 class="text-2xl font-bold text-[#5F1D2A]">Belum ada Produk</h2>
                        <p class="text-[#5F1D2A]/60 mt-2">Maaf, saat ini kami belum memiliki koleksi untuk kategori ini.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white border border-[#B8A5A8] rounded-xl shadow-sm hover:shadow-md transition duration-300 overflow-hidden group flex flex-col h-full">
                                
                                <div class="h-48 bg-gray-200 relative overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-[#F8D9DF]">
                                            <span class="text-[#5F1D2A]/40 font-medium">No Image</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-4 flex flex-col flex-grow">
                                    <span class="text-xs text-[#5F1D2A]/60 mb-1 uppercase tracking-wider">
                                        {{ $product->category->name ?? 'Batik' }}
                                    </span>
                                    
                                    <h3 class="text-lg font-bold text-[#5F1D2A] mb-2 line-clamp-2 leading-tight">
                                        {{ $product->name }}
                                    </h3>
                                    
                                    <div class="mt-auto pt-3 flex items-center justify-between border-t border-[#B8A5A8]/20">
                                        <span class="text-[#5F1D2A] font-bold">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                        <button class="bg-[#5F1D2A] text-white p-2 rounded-lg hover:bg-[#4a1620] transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
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