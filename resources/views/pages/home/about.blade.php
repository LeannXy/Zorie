{{-- resources/views/about.blade.php --}}
@extends('layouts.app')


@section('content')

@include('pages.home.sections.navbar')

{{-- TOP BAR --}}
<div class="bg-[#1a2340] text-white text-xs py-2">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1.55 13.55A2 2 0 008.54 23h6.92a2 2 0 001.99-1.45L19 8M10 12h4" />
            </svg>
            <span></span>
        </div>
        <div class="flex items-center gap-6">
            <a href="#" class="flex items-center gap-1 hover:text-gray-300 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Bantuan
            </a>
            <a href="#" class="flex items-center gap-1 hover:text-gray-300 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Lacak Pesanan
            </a>
            <a href="{{ route('customer.login') }}" class="flex items-center gap-1 hover:text-gray-300 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Masuk / Daftar
            </a>
        </div>
    </div>
</div>



{{-- HERO SECTION: TENTANG ZORIE --}}
<section class="bg-[#f0f2f7] py-16">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center gap-10">
        {{-- Text --}}
        <div class="flex-1 max-w-xl">
            <h1 class="text-4xl md:text-5xl font-extrabold text-[#1a2340] uppercase tracking-tight mb-3">
                Tentang ZORIE
            </h1>
            <p class="text-gray-600 text-base md:text-lg mb-4 italic">Langkah Nyaman, Gaya Tanpa Batas</p>
            <p class="text-gray-600 text-sm leading-relaxed">
                Zorie adalah toko sepatu yang menyediakan berbagai pilihan sepatu
                berkualitas dari brand-brand terbaik untuk menunjang setiap langkah
                Anda. Kami berkomitmen untuk menghadirkan produk original dengan
                harga terbaik dan pelayanan yang memuaskan.
            </p>
        </div>
        {{-- Image --}}
        <div class="flex-1 flex justify-end">
            <img
                src="{{ asset('images/about/hero-shoe.png') }}"
                alt="ZORIE Shoe"
                class="w-full max-w-md object-contain drop-shadow-xl"
            />
        </div>
    </div>
</section>

{{-- CERITA KAMI + VALUE PROPS --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-0 items-stretch">

        {{-- Store Image --}}
        <div class="col-span-1">
            <img
                src="{{ asset('images/about/store.png') }}"
                alt="ZORIE Store"
                class="w-full h-full object-cover"
                style="min-height: 320px;"
            />
        </div>

        {{-- Cerita Kami Text --}}
        <div class="col-span-1 bg-white px-8 py-10 flex flex-col justify-center">
            <h2 class="text-xl font-extrabold text-[#1a2340] uppercase tracking-widest mb-4">Cerita Kami</h2>
            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                Berawal dari keinginan untuk menyediakan sepatu berkualitas dengan pilihan beragam,
                Zorie hadir sebagai solusi bagi Anda yang mencari sepatu original, nyaman, dan
                stylish untuk berbagai kesempatan.
            </p>
            <p class="text-gray-600 text-sm leading-relaxed">
                Kepuasan pelanggan adalah motivasi kami untuk terus berkembang dan menjadi toko
                sepatu terpercaya di Indonesia.
            </p>
        </div>

        {{-- Value Props Grid --}}
        <div class="col-span-1 grid grid-cols-2 border-l border-gray-100">

            {{-- Produk Original --}}
            <div class="flex flex-col items-start gap-3 p-6 border-b border-r border-gray-100">
                <div class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-[#1a2340]">
                    <svg class="w-5 h-5 text-[#1a2340]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-[#1a2340] text-sm uppercase tracking-wide mb-1">Produk Original</h3>
                    <p class="text-gray-500 text-xs leading-relaxed">Kami hanya menyediakan produk 100% original dari brand terpercaya.</p>
                </div>
            </div>

            {{-- Kualitas Terjamin --}}
            <div class="flex flex-col items-start gap-3 p-6 border-b border-gray-100">
                <div class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-[#1a2340]">
                    <svg class="w-5 h-5 text-[#1a2340]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-[#1a2340] text-sm uppercase tracking-wide mb-1">Kualitas Terjamin</h3>
                    <p class="text-gray-500 text-xs leading-relaxed">Setiap produk dipilih dengan standar kualitas terbaik untuk kenyamanan Anda.</p>
                </div>
            </div>

            {{-- Harga Terbaik --}}
            <div class="flex flex-col items-start gap-3 p-6 border-r border-gray-100">
                <div class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-[#1a2340]">
                    <svg class="w-5 h-5 text-[#1a2340]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-[#1a2340] text-sm uppercase tracking-wide mb-1">Harga Terbaik</h3>
                    <p class="text-gray-500 text-xs leading-relaxed">Dapatkan sepatu berkualitas dengan harga yang kompetitif dan bersahabat.</p>
                </div>
            </div>

            {{-- Pelayanan Ramah --}}
            <div class="flex flex-col items-start gap-3 p-6">
                <div class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-[#1a2340]">
                    <svg class="w-5 h-5 text-[#1a2340]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-[#1a2340] text-sm uppercase tracking-wide mb-1">Pelayanan Ramah</h3>
                    <p class="text-gray-500 text-xs leading-relaxed">Tim kami siap membantu Anda dengan pelayanan yang cepat dan ramah.</p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- VISI MISI MOTTO KOMITMEN --}}
<section class="py-16 bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10">

        {{-- Visi --}}
        <div class="flex flex-col items-start gap-4">
            <div class="w-14 h-14 flex items-center justify-center rounded-full border-2 border-[#1a2340]">
                {{-- Target / bullseye icon --}}
                <svg class="w-7 h-7 text-[#1a2340]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-width="2"/>
                    <circle cx="12" cy="12" r="6" stroke-width="2"/>
                    <circle cx="12" cy="12" r="2" stroke-width="2"/>
                    <line x1="12" y1="2" x2="12" y2="5" stroke-width="2"/>
                    <line x1="20" y1="12" x2="17" y2="12" stroke-width="2"/>
                </svg>
            </div>
            <div>
                <h3 class="font-extrabold text-[#1a2340] uppercase tracking-widest text-sm mb-2">Visi</h3>
                <p class="text-gray-500 text-xs leading-relaxed">
                    Menjadi toko sepatu terpercaya yang memberikan pengalaman belanja terbaik dan produk berkualitas untuk semua.
                </p>
            </div>
        </div>

        {{-- Misi --}}
        <div class="flex flex-col items-start gap-4">
            <div class="w-14 h-14 flex items-center justify-center rounded-full border-2 border-[#1a2340]">
                <svg class="w-7 h-7 text-[#1a2340]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.82m5.84-2.56a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.83m2.55-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                </svg>
            </div>
            <div>
                <h3 class="font-extrabold text-[#1a2340] uppercase tracking-widest text-sm mb-2">Misi</h3>
                <ul class="text-gray-500 text-xs leading-relaxed space-y-1 list-disc list-inside">
                    <li>Menyediakan sepatu original dari brand terbaik</li>
                    <li>Memberikan harga yang kompetitif</li>
                    <li>Mengutamakan kepuasan pelanggan</li>
                    <li>Terus berinovasi dan berkembang</li>
                </ul>
            </div>
        </div>

        {{-- Motto --}}
        <div class="flex flex-col items-start gap-4">
            <div class="w-14 h-14 flex items-center justify-center rounded-full border-2 border-[#1a2340]">
                <svg class="w-7 h-7 text-[#1a2340]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <div>
                <h3 class="font-extrabold text-[#1a2340] uppercase tracking-widest text-sm mb-2">Motto</h3>
                <p class="text-gray-500 text-xs leading-relaxed">
                    Melangkah dengan percaya diri, nyaman di setiap langkah bersama Zorie.
                </p>
            </div>
        </div>

        {{-- Komitmen --}}
        <div class="flex flex-col items-start gap-4">
            <div class="w-14 h-14 flex items-center justify-center rounded-full border-2 border-[#1a2340]">
                <svg class="w-7 h-7 text-[#1a2340]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div>
                <h3 class="font-extrabold text-[#1a2340] uppercase tracking-widest text-sm mb-2">Komitmen</h3>
                <p class="text-gray-500 text-xs leading-relaxed">
                    Kami berkomitmen untuk terus memberikan produk dan layanan terbaik bagi pelanggan setia Zorie.
                </p>
            </div>
        </div>

    </div>
</section>

{{-- FOOTER --}}
<footer class="bg-[#1a2340] text-white py-5">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-6 text-center text-sm">

        <div class="flex flex-col items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1.55 13.55A2 2 0 008.54 23h6.92a2 2 0 001.99-1.45L19 8" />
            </svg>
            <span>Gratis Ongkir Seluruh Indonesia</span>
        </div>

        <div class="flex flex-col items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span>Produk 100% Original</span>
        </div>

        <div class="flex flex-col items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <span>Pembayaran Aman</span>
        </div>

        <div class="flex flex-col items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            <span>Customer Service Responsif</span>
        </div>

    </div>
</footer>

@endsection