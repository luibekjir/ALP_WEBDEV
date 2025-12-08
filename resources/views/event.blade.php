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
            </div>

            @if($events->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 text-center bg-white border border-[#B8A5A8] border-dashed rounded-xl">
                    <div class="text-[#5F1D2A]/40 text-6xl mb-4">☹</div>
                    <h2 class="text-2xl font-bold text-[#5F1D2A]">Belum ada Acara</h2>
                    <p class="text-[#5F1D2A]/60 mt-2">Maaf, saat ini kami belum memiliki acara yang tersedia.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-2 gap-6">
                    @foreach($events as $event)
                        <div class="bg-white border border-[#B8A5A8] rounded-xl shadow-sm hover:shadow-md transition duration-300 overflow-hidden group flex flex-col h-full">
                            
                            {{-- Image --}}
                            <div class="h-48 bg-gray-200 relative overflow-hidden">
                                @if($event->image_url)
                                    <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-[#F8D9DF]">
                                        <span class="text-[#5F1D2A]/40 font-medium">No Image</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-4 flex flex-col flex-grow">
                                {{-- Date --}}
                                <span class="text-xs text-[#5F1D2A]/60 mb-1 uppercase tracking-wider">
                                    {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('d M Y H:i') : 'Tanggal Tidak Tersedia' }}
                                </span>

                                {{-- Title --}}
                                <h3 class="text-lg font-bold text-[#5F1D2A] mb-2 line-clamp-2 leading-tight">
                                    {{ $event->title }}
                                </h3>

                                {{-- Description --}}
                                <p class="text-[#5F1D2A]/80 mb-3 line-clamp-3">
                                    {{ $event->description }}
                                </p>

                                {{-- Price + Button --}}
                                <div class="mt-auto pt-3 flex items-center justify-between border-t border-[#B8A5A8]/20">
                                    <span class="text-[#5F1D2A] font-bold">
                                        @if($event->price)
                                            Rp {{ number_format($event->price, 0, ',', '.') }}
                                        @else
                                            Gratis
                                        @endif
                                    </span>

                                    <button class="bg-[#5F1D2A] text-white px-3 py-2 rounded-lg hover:bg-[#4a1620] transition text-sm font-medium">
                                        Daftar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Pagination jika perlu --}}
            <div class="mt-12">
                {{ $events->links() }}
            </div>
        </main>
    </div>
</div>

@endsection
