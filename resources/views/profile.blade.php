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

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5F1D2A] mb-2">
                                Alamat Default
                            </label>

                            <div class="bg-[#FFF8F6] border border-[#B8A5A8]/30 rounded-lg px-4 py-3 text-[#5F1D2A]/80">
                                @if ($defaultAddress)
                                    {{ $defaultAddress->address }},
                                    {{ $defaultAddress->subdistrict }},
                                    {{ $defaultAddress->district }},
                                    {{ $defaultAddress->city }},
                                    {{ $defaultAddress->zip_code }}
                                @else
                                    <span class="italic text-[#5F1D2A]/50">Belum ada alamat</span>
                                @endif
                            </div>
                            <div class="flex gap-4 mt-3">
                                <button onclick="openAddressModal()"
                                    class="text-sm font-semibold text-[#5F1D2A] underline hover:text-[#4a1620]">
                                    Ganti Alamat
                                </button>

                                <button onclick="openAddAddressModal()"
                                    class="text-sm font-semibold text-[#5F1D2A] underline hover:text-[#4a1620]">
                                    Tambah Alamat
                                </button>
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

                {{-- EVENT HISTORY --}}
                <div class="bg-white border border-[#B8A5A8] rounded-xl shadow-md p-8 mb-8">
                    <h3 class="text-xl font-bold text-[#5F1D2A] mb-6">
                        Riwayat Event
                    </h3>

                    @if ($events->isEmpty())
                        <div class="text-center py-10 text-[#5F1D2A]/60">
                            <p>Belum pernah mendaftar event</p>
                        </div>
                    @else
                        <div class="space-y-5">
                            @foreach ($events as $event)
                                @php
                                    $isPast = $event->date && $event->date->isPast();
                                @endphp

                                <div class="border border-[#B8A5A8]/30 rounded-xl p-5">

                                    {{-- HEADER --}}
                                    <div class="flex justify-between items-center mb-3">
                                        <div>
                                            <p class="font-semibold text-[#5F1D2A]">
                                                {{ $event->title }}
                                            </p>
                                            <p class="text-sm text-[#5F1D2A]/60">
                                                {{ $event->date?->format('d M Y, H:i') ?? 'Tanggal belum ditentukan' }}
                                            </p>
                                        </div>

                                        {{-- STATUS --}}
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-semibold
                            {{ $isPast ? 'bg-gray-100 text-gray-700' : 'bg-green-100 text-green-700' }}">
                                            {{ $isPast ? 'Selesai' : 'Upcoming' }}
                                        </span>
                                    </div>

                                    {{-- INFO --}}
                                    <div class="flex justify-between text-sm text-[#5F1D2A]/80">
                                        <span>
                                            Daftar:
                                            {{ $event->pivot->registered_at ? \Carbon\Carbon::parse($event->pivot->registered_at)->format('d M Y') : '-' }}
                                        </span>

                                        <span class="font-semibold">
                                            @if ($event->price)
                                                Rp {{ number_format($event->price, 0, ',', '.') }}
                                            @else
                                                Gratis
                                            @endif
                                        </span>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>


                {{-- ORDER HISTORY --}}
                <div class="bg-white border border-[#B8A5A8] rounded-xl shadow-md p-8 mb-8">
                    <h3 class="text-xl font-bold text-[#5F1D2A] mb-6">
                        Riwayat Pesanan
                    </h3>

                    @if ($orders->isEmpty())
                        <div class="text-center py-10 text-[#5F1D2A]/60">
                            <p>Belum ada pesanan</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach ($orders as $order)
                                <div class="border border-[#B8A5A8]/30 rounded-xl p-6">

                                    {{-- HEADER --}}
                                    <div class="flex justify-between items-center mb-4">
                                        <div>
                                            <p class="font-semibold text-[#5F1D2A]">
                                                Order #{{ $order->id }}
                                            </p>
                                            <p class="text-sm text-[#5F1D2A]/60">
                                                {{ $order->created_at->format('d M Y, H:i') }}
                                            </p>
                                        </div>

                                        {{-- STATUS --}}
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-semibold
                            @if ($order->status === 'pending') bg-yellow-100 text-yellow-700
                            @elseif($order->status === 'paid') bg-green-100 text-green-700
                            @elseif($order->status === 'shipped') bg-blue-100 text-blue-700
                            @else bg-gray-100 text-gray-700 @endif
                        ">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>

                                    {{-- ITEMS --}}
                                    {{-- <div class="space-y-2 mb-4">
                                        @foreach ($order->items as $item)
                                            <div class="flex justify-between text-sm">
                                                <span>
                                                    {{ $item->product->name }} × {{ $item->quantity }}
                                                </span>
                                                <span>
                                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div> --}}

                                    {{-- TOTAL --}}
                                    <div class="flex justify-between items-center border-t pt-4">
                                        <span class="font-semibold text-[#5F1D2A]">
                                            Total
                                        </span>
                                        <span class="font-bold text-[#5F1D2A] text-lg">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    {{-- ACTION --}}
                                    {{-- NEXT STEP --}}

                                    <div class="mt-4 text-right">
                                        <a href="{{ route('orders.detail', $order) }}"
                                            class="text-[#5F1D2A] hover:underline font-semibold">
                                            Lihat Detail
                                        </a>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @endif
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
                            <form action="{{ route('profile.change-password', $user) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" id="change-password"
                                    class="text-[#5F1D2A] hover:text-[#4a1620] font-semibold">Ubah</button>
                            </form>
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
                            <input type="email" id="email" name="email"
                                value="{{ old('email', $user->email) }}"
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
                            <input type="tel" id="phone" name="phone"
                                value="{{ old('phone', $user->phone) }}"
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


    <div id="addressModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full">

                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h3 class="text-lg font-bold text-[#5F1D2A]">
                        Pilih Alamat
                    </h3>
                    <button onclick="closeAddressModal()" class="text-xl">&times;</button>
                </div>

                <div class="p-6 space-y-3 max-h-[60vh] overflow-y-auto">
                    @foreach ($addresses as $address)
                        <form action="{{ route('address.set-default', $address) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <button type="submit"
                                class="w-full text-left border rounded-lg px-4 py-3
                            {{ $address->is_default ? 'border-[#5F1D2A] bg-[#F8D9DF]' : 'border-gray-300 hover:bg-gray-50' }}">
                                <p class="font-semibold text-[#5F1D2A]">
                                    {{ $address->address }}
                                </p>
                                <p class="text-sm text-[#5F1D2A]/70">
                                    {{ $address->district }}, {{ $address->city }}
                                </p>
                            </button>
                        </form>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <div id="addAddressModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">

            <form action="{{ route('address.store') }}" method="POST" x-data="addressForm()" x-init="fetchProvinces()"
                class="bg-white rounded-xl shadow-xl max-w-xl w-full p-6 space-y-4">

                @csrf

                <h3 class="text-lg font-bold text-[#5F1D2A]">Tambah Alamat</h3>

                {{-- Nama alamat --}}
                <div>
                    <label class="text-sm font-semibold">Nama Alamat</label>
                    <input name="name" required placeholder="Contoh: Rumah"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                {{-- Provinsi --}}
                <div>
                    <label class="text-sm font-semibold">Provinsi</label>
                    <select name="province" x-model="selectedProvince" @change="fetchCities()" required
                        class="w-full border rounded-lg px-4 py-2">

                        <option value="">-- Pilih Provinsi --</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province['id'] }}|{{ $province['name'] }}">{{ $province['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kota --}}
                <div>
                    <label class="text-sm font-semibold">Kota</label>
                    <select name="city" x-model="selectedCity" @change="fetchDistricts()" :disabled="!cities.length"
                        required class="w-full border rounded-lg px-4 py-2 disabled:bg-gray-100">

                        <option value="">-- Pilih Kota --</option>
                        <template x-for="city in cities" :key="city.id">
                            <option :value="city.id + '|' + city.name" x-text="city.name"></option>
                        </template>
                    </select>
                </div>

                {{-- Kecamatan --}}
                <div>
                    <label class="text-sm font-semibold">Kecamatan</label>
                    <select name="district" x-model="selectedDistrict" @change="fetchSubDistricts()"
                        :disabled="!districts.length === 0" required
                        class="w-full border rounded-lg px-4 py-2 disabled:bg-gray-100">

                        <option value="">Pilih Kecamatan</option>
                        <template x-for="district in districts" :key="district.id">
                            <option :value="district.id + '|' + district.name" x-text="district.name"></option>
                        </template>
                    </select>
                </div>

                {{-- Kelurahan --}}
                <div>
                    <label class="text-sm font-semibold">Kelurahan</label>
                    <select name="subdistrict" x-model="selectedSubDistrict" :disabled="!subDistricts.length === 0"
                        required class="w-full border rounded-lg px-4 py-2 disabled:bg-gray-100">
                        <option value="">Pilih Kelurahan</option>
                        <template x-for="sub in subDistricts" :key="sub.id">
                            <option :value="sub.id + '|' + sub.name" x-text="sub.name"></option>
                        </template>
                    </select>
                </div>

                {{-- Kode pos --}}
                <div>
                    <label class="text-sm font-semibold">Kode Pos</label>
                    <input name="postal_code" required class="w-full border rounded-lg px-4 py-2"
                        placeholder="Masukkan kode pos">
                </div>

                {{-- Jalan --}}
                <div>
                    <label class="text-sm font-semibold">Jalan</label>
                    <input name="extra_detail" required class="w-full border rounded-lg px-4 py-2"
                        placeholder="Jl. Merdeka No. 10">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeAddAddressModal()" class="flex-1 border rounded-lg py-2">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-[#5F1D2A] text-white rounded-lg py-2">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>





    <script>
        function addressForm() {
            return {
                selectedProvince: '',
                selectedCity: '',
                selectedDistrict: '',
                selectedSubDistrict: '',
                cities: [],
                districts: [],
                subDistricts: [],
                async fetchProvinces() {
                    const response = await fetch('/komerce/provinces');
                    this.provinces = await response.json();
                },
                async fetchCities() {
                    this.cities = [];
                    this.districts = [];
                    this.subDistricts = [];

                    if (!this.selectedProvince) return;

                    const provinceId = this.selectedProvince.split('|')[0];

                    const res = await fetch(`/komerce/cities/${provinceId}`);

                    if (!res.ok) {
                        console.error('Fetch cities failed');
                        return;
                    }

                    const json = await res.json();
                    this.cities = Array.isArray(json) ? json : [];
                },
                async fetchDistricts() {
                    this.districts = [];
                    this.subDistricts = [];

                    this.selectedDistrict = '';
                    this.selectedSubDistrict = '';

                    if (!this.selectedCity) return;

                    const cityId = this.selectedCity.split('|')[0];

                    const res = await fetch(`/komerce/districts/${cityId}`);
                    this.districts = await res.json();
                },
                async fetchSubDistricts() {
                    this.subDistricts = [];
                    this.selectedSubDistrict = '';

                    if (!this.selectedDistrict) return;

                    const districtId = this.selectedDistrict.split('|')[0];

                    const res = await fetch(`/komerce/subdistricts/${districtId}`);
                    this.subDistricts = await res.json();
                }
            }
        }

        function openAddAddressModal() {
            document.getElementById('addAddressModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAddAddressModal() {
            document.getElementById('addAddressModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

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
