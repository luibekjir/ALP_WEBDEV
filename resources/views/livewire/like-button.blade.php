<div>
    <button wire:click="toggleLike" class="flex items-center gap-1 text-[#5F1D2A]/80 hover:text-[#5F1D2A] transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-all duration-200" viewBox="0 0 24 24"
            fill="{{ $liked ? '#ED4956' : 'none' }}" stroke="{{ $liked ? '#ED4956' : 'currentColor' }}" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 21s-6.716-4.418-9.428-7.13C.86 12.158.86 8.843 3.172 6.53 5.485 4.218 8.8 4.218 11.113 6.53L12 7.418l.887-.887c2.313-2.312 5.628-2.312 7.94 0 2.313 2.313 2.313 5.628 0 7.94C18.716 16.582 12 21 12 21z" />
        </svg>

        Like ({{ $likesCount }})
    </button>
</div>
