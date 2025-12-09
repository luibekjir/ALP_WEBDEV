@extends('section.layout')

@section('content')

<!-- Header Lebar -->
<div class="w-full bg-[#F8D9DF] py-16 text-center">
    <h1 class="text-4xl md:text-5xl font-bold text-[#5F1D2A]">Tentang Kami</h1>
    <p class="mt-4 text-[#5F1D2A]/70 max-w-3xl mx-auto text-lg md:text-xl px-6">
        Menemani perjalanan Batik Bulau Sayang dalam menjaga tradisi dan menghadirkan keindahan melalui karya.
    </p>
</div>

<!-- Grid Info Perusahaan -->
<div class="w-full bg-[#FFF8F6] py-16">
    <div class="container mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

        <!-- Visi -->
        <div class="bg-white border border-[#B8A5A8]/50 p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
            <h2 class="text-xl font-semibold text-[#5F1D2A] mb-3">Visi Kami</h2>
            <p class="text-[#5F1D2A]/80">
                Menjadi platform batik terdepan yang menghadirkan nilai budaya dan modernitas secara harmonis.
            </p>
        </div>

        <!-- Misi -->
        <div class="bg-white border border-[#B8A5A8]/50 p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
            <h2 class="text-xl font-semibold text-[#5F1D2A] mb-3">Misi Kami</h2>
            <ul class="list-disc pl-5 text-[#5F1D2A]/80 space-y-2">
                <li>Menghadirkan batik berkualitas dengan sentuhan modern.</li>
                <li>Mendukung pengrajin lokal.</li>
                <li>Membawa budaya batik ke generasi baru.</li>
            </ul>
        </div>

        <!-- Tentang Perusahaan -->
        <div class="bg-white border border-[#B8A5A8]/50 p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
            <h2 class="text-xl font-semibold text-[#5F1D2A] mb-3">Tentang Kami</h2>
            <p class="text-[#5F1D2A]/80">
                Batik Bulau Sayang adalah rumah bagi karya-karya batik yang memadukan kekayaan tradisi dengan desain masa kini. 
                Kami percaya setiap motif memiliki cerita.
            </p>
        </div>

        <!-- Tim Kami -->
        <div class="bg-white border border-[#B8A5A8]/50 p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
            <h2 class="text-xl font-semibold text-[#5F1D2A] mb-3">Tim Kami</h2>
            <p class="text-[#5F1D2A]/80">
                Tim kami terdiri dari pengrajin, desainer, dan kreator yang bekerja bersama untuk menghadirkan karya terbaik.
            </p>
        </div>

        <!-- Nilai Kami -->
        <div class="bg-white border border-[#B8A5A8]/50 p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
            <h2 class="text-xl font-semibold text-[#5F1D2A] mb-3">Nilai Kami</h2>
            <p class="text-[#5F1D2A]/80">
                Keaslian, kualitas, dan inovasi adalah dasar dari setiap kain yang kami hasilkan.
            </p>
        </div>

        <!-- Komitmen -->
        <div class="bg-white border border-[#B8A5A8]/50 p-6 rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
            <h2 class="text-xl font-semibold text-[#5F1D2A] mb-3">Komitmen Kami</h2>
            <p class="text-[#5F1D2A]/80">
                Kami berkomitmen menjaga warisan budaya dan memperkenalkan batik ke dunia melalui karya yang relevan.
            </p>
        </div>

    </div>
</div>

@endsection
