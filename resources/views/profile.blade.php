@extends('section.layout')

@section('content')

    <!-- Header -->
    <div class="w-full bg-gradient-to-b from-[#F8D9DF] to-[#FFD6E0] py-14 text-center">
        <h1 class="text-4xl font-bold text-[#5F1D2A]">Profil Saya</h1>
        <p class="mt-3 text-[#5F1D2A]/70 max-w-2xl mx-auto">
            Kelola informasi akun dan preferensi Anda
        </p>
    </div>

    <div class="w-full bg-[#FFF8F6] min-h-screen">
        <div class="container mx-auto py-12 px-6">
            <div class="max-w-2xl mx-auto">

                <!-- Profile Card -->
                <div class="bg-white border border-[#B8A5A8] rounded-xl shadow-md p-8 mb-8">

                    <!-- Avatar Section -->
                    <div class="text-center mb-8">
                        <div
                            class="w-24 h-24 mx-auto bg-gradient-to-br from-[#FFD9DC] to-[#F8D9DF] rounded-full flex items-center justify-center mb-4 border-2 border-[#B8A5A8]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#5F1D2A]" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-[#5F1D2A]">{{ $user->name }}</h2>
                        <p class="text-[#5F1D2A]/70 mt-1">{{ ucfirst($user->role) }}</p>
                    </div>
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif
                    <!-- Information Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-[#5F1D2A] mb-2">Email</label>
                            <div class="bg-[#FFF8F6] border border-[#B8A5A8]/30 rounded-lg px-4 py-3 text-[#5F1D2A]/80">
                                {{ $user->email }}
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-semibold text-[#5F1D2A] mb-2">Telepon</label>
                            <div class="bg-[#FFF8F6] border border-[#B8A5A8]/30 rounded-lg px-4 py-3 text-[#5F1D2A]/80">
                                {{ $user->phone ?? 'Tidak diisi' }}
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5F1D2A] mb-2">Alamat</label>
                            <div
                                class="bg-[#FFF8F6] border border-[#B8A5A8]/30 rounded-lg px-4 py-3 text-[#5F1D2A]/80 min-h-20">
                                {{ $user->address ?? 'Tidak diisi' }}
                            </div>
                        </div>

                        {{-- <!-- Member Since -->
                    <div>
                        <label class="block text-sm font-semibold text-[#5F1D2A] mb-2">Bergabung Sejak</label>
                        <div class="bg-[#FFF8F6] border border-[#B8A5A8]/30 rounded-lg px-4 py-3 text-[#5F1D2A]/80">
                            {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d M Y') : 'N/A' }}
                        </div>
                    </div>

                    <!-- Last Updated -->
                    <div>
                        <label class="block text-sm font-semibold text-[#5F1D2A] mb-2">Terakhir Diubah</label>
                        <div class="bg-[#FFF8F6] border border-[#B8A5A8]/30 rounded-lg px-4 py-3 text-[#5F1D2A]/80">
                            {{ $user->updated_at ? \Carbon\Carbon::parse($user->updated_at)->format('d M Y H:i') : 'N/A' }}
                        </div>
                    </div> --}}
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button onclick="openEditModal()"
                            class="flex-1 bg-[#5F1D2A] text-white px-6 py-3 rounded-lg hover:bg-[#4a1620] transition font-semibold text-center">
                            Edit Profil
                        </button>
                        {{-- <a href="{{ route('profile.change-password', $user->id) }}" 
                       class="flex-1 border-2 border-[#5F1D2A] text-[#5F1D2A] px-6 py-3 rounded-lg hover:bg-[#F8D9DF] transition font-semibold text-center">
                        Ubah Password
                    </a> --}}
                        <form action="{{ route('logout') }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full border-2 border-red-500 text-red-500 px-6 py-3 rounded-lg hover:bg-red-50 transition font-semibold">
                                Logout
                            </button>
                        </form>
                        <form action="{{ route('profile.destroy') }}" method="POST" class="flex-1"
                            onsubmit="return confirmDeleteAccount()">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="w-full border-2 border-red-700 text-red-700 px-6 py-3 rounded-lg hover:bg-red-100 transition font-semibold">
                                Hapus Akun
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Security Section -->
                <div class="bg-white border border-[#B8A5A8] rounded-xl shadow-md p-8">
                    <h3 class="text-xl font-bold text-[#5F1D2A] mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Keamanan
                    </h3>

                    <div class="space-y-4">
                        <div
                            class="flex items-center justify-between p-4 bg-[#FFF8F6] border border-[#B8A5A8]/30 rounded-lg">
                            <div>
                                <p class="font-semibold text-[#5F1D2A]">Password</p>
                                <p class="text-sm text-[#5F1D2A]/70">Ubah password akun Anda</p>
                            </div>
                            {{-- <a href="{{ route('profile.change-password', $user) }}" 
                           class="text-[#5F1D2A] hover:text-[#4a1620] font-semibold">
                            Ubah
                        </a> --}}
                            <a href="{{ route('profile.change-password') }}"
                                class="text-[#5F1D2A] hover:text-[#4a1620] font-semibold">Ubah</a>
                        </div>

                        {{-- <div class="flex items-center justify-between p-4 bg-[#FFF8F6] border border-[#B8A5A8]/30 rounded-lg">
                        <div>
                            <p class="font-semibold text-[#5F1D2A]">Email</p>
                            <p class="text-sm text-[#5F1D2A]/70">{{ $user->email }}</p>
                        </div>
                        {{-- <span class="text-green-600 font-semibold">✓ Terverifikasi</span> --}}
                        {{-- </div> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-[#F8D9DF] to-[#FFD9DC] px-6 py-4 rounded-t-xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-[#5F1D2A]">Edit Profil</h3>
                        <button onclick="closeEditModal()"
                            class="text-[#5F1D2A] hover:text-[#4a1620] text-2xl">&times;</button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6">

                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update', $user) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-[#5F1D2A] mb-2">Nama
                                Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full border border-[#B8A5A8]/30 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#FFD9DC] focus:border-transparent"
                                required>
                            @error('name')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-[#5F1D2A] mb-2">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full border border-[#B8A5A8]/30 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#FFD9DC] focus:border-transparent"
                                required>
                            @error('email')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-[#5F1D2A] mb-2">Nomor
                                Telepon</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="w-full border border-[#B8A5A8]/30 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#FFD9DC] focus:border-transparent"
                                placeholder="Contoh: 081234567890">
                            @error('phone')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-semibold text-[#5F1D2A] mb-2">Alamat
                                Lengkap</label>
                            <textarea id="address" name="address" rows="4"
                                class="w-full border border-[#B8A5A8]/30 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#FFD9DC] focus:border-transparent resize-none"
                                placeholder="Masukkan alamat lengkap Anda">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex gap-3 pt-4 border-t border-[#B8A5A8]/20">
                            <button type="button" onclick="closeEditModal()"
                                class="flex-1 border-2 border-[#B8A5A8] text-[#5F1D2A] px-6 py-3 rounded-lg hover:bg-[#F8D9DF] transition font-semibold">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 bg-[#5F1D2A] text-white px-6 py-3 rounded-lg hover:bg-[#4a1620] transition font-semibold">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('editModal').classList.contains('hidden')) {
                closeEditModal();
            }
        });

        function confirmDeleteAccount() {
        return confirm(
            '⚠️ Apakah Anda yakin ingin menghapus akun ini?\n\nTindakan ini TIDAK dapat dibatalkan.'
        );
    }

    </script>

@endsection
