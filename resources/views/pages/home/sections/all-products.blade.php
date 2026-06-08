@extends('layouts.app')

@section('content')
    @include('pages.home.sections.navbar')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        .catalog-wrap * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .catalog-wrap {
            background: #fcfcfc;
            min-height: 100vh;
            padding-top: 0; /* Menghilangkan space berlebih karena navbar sudah punya spacer */
        }

        /* ── BREADCRUMB ── */
        .catalog-breadcrumb {
            padding: 16px 40px;
            font-size: 11px;
            color: #aaa;
            letter-spacing: .05em;
            text-transform: uppercase;
            font-weight: 600;
            border-bottom: 1px solid #f0f0ee; /* Garis estetik pertama */
        }

        .catalog-breadcrumb a {
            color: #aaa;
            text-decoration: none;
        }

        .catalog-breadcrumb a:hover {
            color: #000039;
        }

        /* ── FILTER ROW ── */
        .catalog-filter-row {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 40px;
            background: #fff;
            overflow-x: auto;
            scrollbar-width: none;
            border-bottom: 1px solid #f0f0ee; /* Garis estetik antar filter */
        }
        .catalog-filter-row::-webkit-scrollbar { display: none; }

        .filter-section-label {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #ccc;
            margin-right: 8px;
            white-space: nowrap;
        }

        .catalog-filter-chip {
            padding: 8px 18px;
            font-size: 10.5px;
            font-weight: 700;
            color: #555;
            border: 1px solid #e5e5e3;
            border-radius: 12px;
            background: #fff;
            cursor: pointer;
            transition: all .25s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: .02em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .catalog-filter-chip:hover {
            border-color: #000039;
            color: #000039;
            transform: translateY(-1px);
        }

        .catalog-filter-chip.active {
            color: #fff;
            background: #000039;
            border-color: #000039;
            box-shadow: 0 4px 12px rgba(0, 0, 57, 0.15);
        }

        /* ── SORT SELECT ── */
        .catalog-sort-select {
            padding: 8px 16px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .02em;
            border: 1px solid #e5e5e3;
            border-radius: 12px;
            outline: none;
            color: #000039;
            cursor: pointer;
            background: #fff;
            text-transform: uppercase;
        }

        /* ── PRODUCT GRID ── */
        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 24px;
            padding: 30px 40px 40px;
        }

        .prod-card {
            position: relative;
            background: #fff;
            border-radius: 20px;
            padding: 12px;
            border: 1px solid #f0f0ee;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            cursor: pointer;
            display: flex;
            flex-direction: column;
        }

        .prod-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 57, 0.06);
            border-color: #e5e5e3;
        }

        .prod-image-wrap {
            position: relative;
            width: 100%;
            padding-bottom: 100%;
            background: #f8f8f6;
            border-radius: 14px;
            overflow: hidden;
        }

        .prod-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 20px;
            transition: transform .6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .prod-card:hover .prod-image {
            transform: scale(1.1);
        }

        .prod-info {
            padding: 16px 8px 8px;
        }

        .prod-brand {
            font-size: 9px;
            font-weight: 800;
            color: #bbb;
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .prod-name {
            font-size: 15px;
            font-weight: 700;
            color: #000039;
            letter-spacing: .2px;
            line-height: 1.3;
            margin-bottom: 12px;
        }

        .prod-price-label {
            display: block;
            font-size: 9px;
            font-weight: 400;
            color: #bbb;
            letter-spacing: .5px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .prod-price {
            font-size: 16px;
            font-weight: 800;
            color: #000039;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── EMPTY STATE ── */
        .catalog-empty {
            grid-column: 1 / -1;
            padding: 100px 0;
            text-align: center;
            color: #ccc;
        }

        @media (max-width: 768px) {
            .catalog-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
                padding: 20px;
            }
            .catalog-breadcrumb, .catalog-filter-row { padding-left: 20px; padding-right: 20px; }
        }
    </style>

    <div class="catalog-wrap">

        {{-- BREADCRUMB --}}
        <div class="catalog-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            &nbsp;/&nbsp;
            <span>

                {{ request('category') ? ucfirst(request('category')) : 'All Products' }}

            </span>
        </div>

        {{-- FILTER ROW — CATEGORY & SORT --}}
        <div class="catalog-filter-row">

            <span class="filter-section-label">Kategori</span>

            <a href="{{ route('all-products') }}" class="catalog-filter-chip {{ request('category') ? '' : 'active' }}">

                Semua

            </a>

            @foreach ($categories as $category)
                <a href="{{ route('all-products', [
                    'category' => $category->slug,
                    'sort' => request('sort'),
                ]) }}"
                    class="catalog-filter-chip {{ request('category') === $category->slug ? 'active' : '' }}">

                    {{ $category->name }}

                </a>
            @endforeach

            <div style="flex:1"></div>

            <select onchange="window.location.href=this.value" class="catalog-sort-select">

                <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}"
                    {{ request('sort') === 'latest' ? 'selected' : '' }}>

                    Terbaru

                </option>

                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}"
                    {{ request('sort') === 'price_low' ? 'selected' : '' }}>

                    Harga Terendah

                </option>

                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}"
                    {{ request('sort') === 'price_high' ? 'selected' : '' }}>

                    Harga Tertinggi

                </option>

            </select>

        </div>

        {{-- FILTER ROW — BRAND --}}
        <div class="catalog-filter-row">

            <span class="filter-section-label">Ukuran</span>

            <a href="{{ request()->fullUrlWithQuery(['size' => null]) }}" class="catalog-filter-chip">

                Semua

            </a>

            @foreach ($sizes as $size)
                <a href="{{ request()->fullUrlWithQuery([
                    'size' => $size,
                ]) }}"
                    class="catalog-filter-chip
            {{ request('size') == $size ? 'active' : '' }}">

                    {{ $size }}

                </a>
            @endforeach

        </div>
        <div class="catalog-filter-row">

            <span class="filter-section-label">Harga</span>

            <select onchange="window.location.href=this.value" class="catalog-sort-select">

                <option>Harga</option>

                <option value="{{ request()->fullUrlWithQuery([
                    'price' => 'under_500k',
                ]) }}">

                    < 500K </option>

                <option value="{{ request()->fullUrlWithQuery([
                    'price' => '500k_1m',
                ]) }}">

                    500K - 1M

                </option>

                <option value="{{ request()->fullUrlWithQuery([
                    'price' => 'above_1m',
                ]) }}">

                    > 1M

                </option>

            </select>

        </div>
        
        <div class="catalog-filter-row bg-[#fcfcfc]">
            <span class="filter-section-label">Status</span>
            <div class="text-[11px] font-bold text-[#ccc] uppercase tracking-wider">
                Menampilkan
                <span class="text-[#000039]">
                    {{ $products->total() }}
                </span>
                Produk Tersedia
            </div>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="catalog-grid">
            @foreach ($products as $product)
                <a href="{{ route('product.show', $product) }}" class="prod-card block">

                    <div class="prod-image-wrap">

                        @if($product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->image) }}"
                                class="prod-image" alt="{{ $product->name }}">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center bg-[#fcfcfc] text-[#ddd] text-[9px] font-black uppercase tracking-widest">
                                No Image
                            </div>
                        @endif
                    </div>

                    <div class="prod-info">

                        <div class="prod-brand">

                            {{ $product->categories->pluck('name')->join(', ') }}

                        </div>

                        <div class="prod-name">

                            {{ $product->name }}

                        </div>

                        <div class="prod-price">
                            <span class="text-[11px] font-bold opacity-40">RP</span>
                            <span>
                                {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </div>
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

                </a>
        @endforeach
        @if ($products->isEmpty())
            <div class="catalog-empty">

                <svg class="w-12 h-12 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <p class="text-[13px] font-bold tracking-widest">TIDAK ADA PRODUK DITEMUKAN</p>
                <p class="text-[11px] mt-2">Coba ubah filter atau pencarian Anda.</p>

            </div>
        @endif
    </div>
    <div class="flex justify-center py-10">

        {{ $products->links() }}

    </div>
    </div>

    </div>
@endsection
