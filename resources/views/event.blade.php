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

                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-[#5F1D2A] mb-4 border-b border-[#B8A5A8]/30 pb-2">
                            Range Harga
                        </h3>
                        <div class="flex items-center gap-2 text-sm text-[#5F1D2A]/70">
                            <span class="bg-[#F8D9DF] px-2 py-1 rounded">Min</span> - <span class="bg-[#F8D9DF] px-2 py-1 rounded">Max</span>
                        </div>
                    </div>
                </div>
            </aside>

            <main class="w-full lg:w-3/4">
                
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <p class="text-[#5F1D2A]/70">
                        Menampilkan <span class="font-bold">{{ $event->count() }}</span> acara
                    </p>

                    @if($event->isEmpty())
                        <div class="flex flex-col items-center justify-center py-20 text-center bg-white border border-[#B8A5A8] border-dashed rounded-xl">
                            <div class="text-[#5F1D2A]/40 text-6xl mb-4">☹</div> <h2 class="text-2xl font-bold text-[#5F1D2A]">Belum ada Acara</h2>
                            <p class="text-[#5F1D2A]/60 mt-2">Maaf, saat ini kami belum memiliki acara yang tersedia.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($event as $event)
                                <div class="bg-white border border-[#B8A5A8] rounded-xl shadow-sm hover:shadow-md transition duration-300 overflow-hidden group flex flex-col h-full">
                                    
                                    <div class="h-48 bg-gray-200 relative overflow-hidden">
                                        @if($event->image)
                                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-[#F8D9DF]">
                                                <span class="text-[#5F1D2A]/40 font-medium">No Image</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-4 flex flex-col flex-grow">
                                        <span class="text-xs text-[#5F1D2A]/60 mb-1 uppercase tracking-wider">{{ $event->date ?? 'Tanggal Tidak Tersedia' }}</span>
                                        
                                        <h3 class="text-lg font-bold text-[#5F1D2A] mb-2 line-clamp-2 leading-tight">
                                            {{ $event->name }}
                                        </h3>
                                        
                                        <div class="mt-auto pt-3 flex items-center justify-between border-t border-[#B8A5A8]/20">
                                            <span class="text-[#5F1D2A] font-bold">
                                                {{ $event->description }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mt-12">
                    {{-- {{ $products->links() }} --}}
                </div>

            </main>
        </div>
    </div>
</div>

@endsection