@extends('section.layout')

@section('content')
<div class="container mx-auto py-12 px-6">
    <div class="max-w-4xl mx-auto">

        <!-- Gallery Detail -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="aspect-w-16 aspect-h-9">
                <img src="{{ asset($gallery->image_url) }}" alt="{{ $gallery->title }}" class="w-full h-96 object-cover">
            </div>

            <div class="p-8">
                <h1 class="text-3xl font-bold text-[#5F1D2A] mb-4">{{ $gallery->title }}</h1>

                <div class="flex items-center gap-4 text-sm text-gray-600 mb-6">
                    <span>{{ $gallery->created_at->format('d M Y') }}</span>
                    <span>{{ $gallery->comments->count() }} komentar</span>
                    <span>{{ $gallery->likedByUsers->count() }} likes</span>
                </div>

                <p class="text-gray-700 leading-relaxed">{{ $gallery->description }}</p>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-2xl font-bold text-[#5F1D2A] mb-6">Komentar ({{ $gallery->comments->count() }})</h2>

            <!-- Add Comment Form (if authenticated) -->
            @auth
                <form action="{{ route('gallery.comment', $gallery->id) }}" method="POST" class="mb-8">
                    @csrf
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gradient-to-br from-[#FFD9DC] to-[#F8D9DF] rounded-full flex items-center justify-center">
                                <span class="text-[#5F1D2A] font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <textarea name="comment" rows="3" placeholder="Tulis komentar Anda..."
                                      class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#FFD9DC] focus:border-transparent"
                                      required></textarea>
                            {{-- @error('comment')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror --}}
                        </div>
                        <div class="flex-shrink-0">
                            <button type="submit" class="bg-[#5F1D2A] text-white px-6 py-3 rounded-lg hover:bg-[#4a1620] transition font-semibold">
                                Kirim
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="bg-[#FFF8F6] border border-[#B8A5A8]/30 rounded-lg p-4 mb-8 text-center">
                    <p class="text-[#5F1D2A]">Silakan <a href="/login" class="font-semibold underline hover:text-[#4a1620]">login</a> untuk menambahkan komentar.</p>
                </div>
            @endauth

            <!-- Comments List -->
            @if($gallery->comments->count() > 0)
                <div class="space-y-6">
                    @foreach($gallery->comments as $comment)
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-gradient-to-br from-[#FFD9DC] to-[#F8D9DF] rounded-full flex items-center justify-center">
                                    <span class="text-[#5F1D2A] font-semibold">{{ substr($comment->user->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="bg-[#FFF8F6] rounded-lg p-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="font-semibold text-[#5F1D2A]">{{ $comment->user->name }}</span>
                                        <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-700">{{ $comment->comment }}</p>
                                    @if(auth()->check() && $comment->user_id == auth()->id())
                                        <form action="{{ route('gallery.delete-comment', $comment) }}" method="POST" class="mt-2" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">💬</div>
                    <h3 class="text-xl font-semibold text-[#5F1D2A] mb-2">Belum ada komentar</h3>
                    <p class="text-gray-600">Jadilah yang pertama memberikan komentar!</p>
                </div>
            @endif
        </div>

        <!-- Back Button -->
        <div class="text-center mt-8">
            <a href="/gallery" class="inline-flex items-center gap-2 bg-[#5F1D2A] text-white px-6 py-3 rounded-lg hover:bg-[#4a1620] transition font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Gallery
            </a>
        </div>
    </div>
</div>
@endsection