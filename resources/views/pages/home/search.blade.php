@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#f5f5f3] pt-9 pb-12">
    @include('pages.home.sections.navbar')
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-4">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <span class="text-gray-300">/</span>
                <span class="text-gray-600">Hasil Pencarian</span>
            </div>
            <h1 class="text-3xl font-bold text-[#111] mb-2">Hasil Pencarian</h1>
            <p class="text-gray-600">
                @if(request('q'))
                    Menampilkan hasil untuk "<span class="font-semibold text-[#111]">{{ request('q') }}</span>"
                @else
                    Masukkan kata kunci untuk mencari produk
                @endif
            </p>
        </div>

        @if($products->count() > 0)
            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @foreach($products as $product)
                    <div class="group bg-white rounded-2xl border border-[#e5e5e3] overflow-hidden hover:shadow-lg transition-all duration-300">
                        <div class="relative aspect-square overflow-hidden bg-[#f5f5f3]">
                            @if($product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->image) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <a href="{{ route('product.show', $product) }}"
                                class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors duration-300 flex items-center justify-center">
                                <button class="opacity-0 group-hover:opacity-100 px-4 py-2 bg-white text-[#111] font-semibold rounded-lg transition-all duration-300">
                                    Lihat Detail
                                </button>
                            </a>
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold text-[#111] mb-2 line-clamp-2 group-hover:text-[#000039]">
                                <a href="{{ route('product.show', $product) }}">{{ $product->name }}</a>
                            </h3>
                            
                            @if($product->categories->first())
                                <p class="text-xs text-gray-500 mb-3">{{ $product->categories->first()->name }}</p>
                            @endif

                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold text-[#111]">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <form action="{{ route('cart.store') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="p-2 rounded-lg bg-[#f5f5f3] text-[#111] hover:bg-[#000039] hover:text-white transition-colors duration-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="flex justify-center mb-12">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="text-2xl font-bold text-[#111] mb-2">Tidak ada hasil</h3>
                <p class="text-gray-600 mb-6">
                    @if(request('q'))
                        Produk dengan kata kunci "<strong>{{ request('q') }}</strong>" tidak ditemukan
                    @else
                        Masukkan kata kunci untuk mencari produk
                    @endif
                </p>
                <a href="{{ route('all-products') }}"
                    class="inline-block px-6 py-2 bg-[#000039] text-white font-semibold rounded-lg hover:bg-[#000039]/85 transition-colors duration-300">
                    Lihat Semua Produk
                </a>
            </div>
        @endif
    </div>

    @include('pages.home.sections.footer')
</div>

@endsection