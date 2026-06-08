@extends('layouts.app')

@section('content')
    @include('pages.home.sections.navbar')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;600;700&family=Barlow+Condensed:wght@400;500;600;700&display=swap');

        .catalog-wrap * {
            font-family: 'Barlow', sans-serif;
        }

        .catalog-wrap {
            background: #fff;
            min-height: 100vh;
            padding-top: 80px;
        }

        /* ── BREADCRUMB ── */
        .catalog-breadcrumb {
            padding: 12px 40px;
            font-size: 11px;
            color: #999;
            letter-spacing: .5px;
            border-bottom: 1.5px solid #d0d0d0;
        }

        .catalog-breadcrumb a {
            color: #999;
            text-decoration: none;
        }

        .catalog-breadcrumb a:hover {
            color: #111;
        }

        /* ── FILTER ROW ── */
        .catalog-filter-row {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 12px 40px;
            border-bottom: 1.5px solid #d0d0d0;
            background: #fff;
        }

        .catalog-filter-chip {
            padding: 5px 14px;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: .8px;
            text-transform: uppercase;
            border: 1.5px solid #ccc;
            background: #fff;
            color: #555;
            cursor: pointer;
            transition: all .15s;
            border-radius: 2px;
        }

        .catalog-filter-chip:hover {
            border-color: #111;
            color: #111;
        }

        .catalog-filter-chip.active {
            background: #111;
            color: #fff;
            border-color: #111;
        }

        /* ── TOOLBAR (count + sort) ── */
        .catalog-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 40px;
            border-bottom: 1.5px solid #d0d0d0;
        }

        .catalog-count {
            font-size: 11px;
            color: #999;
            letter-spacing: .5px;
        }

        .catalog-sort-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .catalog-view-btn {
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #bbb;
            transition: color .15s;
        }

        .catalog-view-btn:hover,
        .catalog-view-btn.active {
            color: #111;
        }

        .catalog-sort-select {
            font-family: 'Barlow', sans-serif;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: .5px;
            border: none;
            outline: none;
            color: #444;
            cursor: pointer;
            background: transparent;
            text-transform: uppercase;
        }

        /* ── GRID ── */
        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            border-left: 1.5px solid #d0d0d0;
            border-top: 1.5px solid #d0d0d0;
        }

        /* ── PRODUCT CARD ── */
        .prod-card {
            border-right: 1.5px solid #d0d0d0;
            border-bottom: 1.5px solid #d0d0d0;
            background: #fff;
            cursor: pointer;
            transition: background .2s;
            position: relative;
        }

        .prod-card:hover {
            background: #fafafa;
        }

        .prod-card:hover .prod-actions {
            opacity: 1;
            transform: translateY(0);
        }

        .prod-img-wrap {
            background: #f6f6f6;
            height: 210px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            border-bottom: 1.5px solid #d0d0d0;
        }

        .prod-img-wrap img {
            width: 160px;
            height: 160px;
            object-fit: contain;
            transition: transform .35s cubic-bezier(.25, .46, .45, .94);
        }

        .prod-card:hover .prod-img-wrap img {
            transform: scale(1.06);
        }

        .prod-info {
            padding: 12px 14px 14px;
        }

        .prod-brand {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #999;
        }

        .prod-name {
            font-size: 11px;
            font-weight: 400;
            color: #333;
            margin-top: 3px;
            line-height: 1.4;
        }

        .prod-price {
            margin-top: 8px;
            font-size: 14px;
            font-weight: 700;
            color: #111;
            letter-spacing: .2px;
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

        /* Quick-add overlay */
        .prod-actions {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: #111;
            display: flex;
            opacity: 0;
            transform: translateY(4px);
            transition: all .2s ease;
            z-index: 10;
        }

        .prod-action-btn {
            flex: 1;
            padding: 9px 0;
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #fff;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: background .15s;
        }

        .prod-action-btn:hover {
            background: #333;
        }

        .prod-action-divider {
            width: 1.5px;
            background: #333;
        }

        /* ── PAGINATION ── */
        .catalog-pagination {
            display: flex;
            align-items: center;
            gap: 2px;
            padding: 24px 40px;
            border-top: 1.5px solid #d0d0d0;
            border-left: 1.5px solid #d0d0d0;
        }

        .page-btn {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 500;
            color: #888;
            border: 1.5px solid transparent;
            cursor: pointer;
            transition: all .15s;
        }

        .page-btn:hover {
            color: #111;
            border-color: #bbb;
        }

        .page-btn.active {
            color: #111;
            border-color: #111;
            font-weight: 700;
        }

        .page-dots {
            font-size: 11px;
            color: #ccc;
            padding: 0 4px;
        }

        /* ── EMPTY STATE ── */
        .catalog-empty {
            grid-column: span 3;
            padding: 80px 0;
            text-align: center;
            color: #bbb;
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
    </style>

    <div class="catalog-wrap" x-data="{
        activeFilter: 'All',
        activeBrand: 'All Brands',
        activeSort: 'По умолчанию',
        viewMode: 'grid',
        products: @js(
    $products->map(function ($product) {
        return [
            'id' => $product->id,

            'name' => $product->name,

            'price' => $product->price,

            'discount' => $product->discount,

            'image' => $product->images->first() ? asset('storage/' . $product->images->first()->image) : '',

            'categories' => $product->categories->pluck('name')->toArray(),
        ];
    }),
),
        get filtered() {
            let p = this.products;
            if (this.activeFilter !== 'All') p = p.filter(x => x.filter === this.activeFilter);
            if (this.activeBrand !== 'All Brands') p = p.filter(x => x.brand === this.activeBrand);
            if (this.activeSort === 'Price: Low to High') p = [...p].sort((a, b) => parseInt(a.price.replace(/\s/g, '')) - parseInt(b.price.replace(/\s/g, '')));
            if (this.activeSort === 'Price: High to Low') p = [...p].sort((a, b) => parseInt(b.price.replace(/\s/g, '')) - parseInt(a.price.replace(/\s/g, '')));
            return p;
        }
    }">

        {{-- BREADCRUMB --}}
        <div class="catalog-breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            &nbsp;/&nbsp;
            <span>All Products</span>
        </div>

        {{-- FILTER ROW — CATEGORY --}}
        <div class="catalog-filter-row">
            @foreach ($filters as $f)
                <button class="catalog-filter-chip" :class="{ 'active': activeFilter === '{{ $f }}' }"
                    @click="activeFilter = '{{ $f }}'">{{ $f }}</button>
            @endforeach
            <div style="flex:1"></div>
            <select class="catalog-sort-select" x-model="activeSort">
                @foreach ($sorts as $s)
                    <option>{{ $s }}</option>
                @endforeach
            </select>
        </div>

        {{-- FILTER ROW — BRAND --}}
        <div class="catalog-filter-row" style="border-top:none; padding-top:8px; padding-bottom:8px; gap:4px;">
            @foreach ($brandFilters as $b)
                <button class="catalog-filter-chip" style="border-radius:50px; font-size:10px;"
                    :class="{ 'active': activeBrand === '{{ $b }}' }"
                    @click="activeBrand = '{{ $b }}'">{{ $b }}</button>
            @endforeach
        </div>

        {{-- TOOLBAR --}}
        <div class="catalog-toolbar">
            <p class="catalog-count">
                Showing: <span x-text="filtered.length"></span> products
            </p>
            <div class="catalog-sort-wrap">
                {{-- Grid icons --}}
                <div class="catalog-view-btn" :class="{ active: viewMode==='grid' }" @click="viewMode='grid'" title="3 col">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <rect x="0" y="0" width="4" height="4" />
                        <rect x="6" y="0" width="4" height="4" />
                        <rect x="12" y="0" width="4" height="4" />
                        <rect x="0" y="6" width="4" height="4" />
                        <rect x="6" y="6" width="4" height="4" />
                        <rect x="12" y="6" width="4" height="4" />
                        <rect x="0" y="12" width="4" height="4" />
                        <rect x="6" y="12" width="4" height="4" />
                        <rect x="12" y="12" width="4" height="4" />
                    </svg>
                </div>
                <div class="catalog-view-btn" :class="{ active: viewMode==='wide' }" @click="viewMode='wide'" title="2 col">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <rect x="0" y="0" width="7" height="7" />
                        <rect x="9" y="0" width="7" height="7" />
                        <rect x="0" y="9" width="7" height="7" />
                        <rect x="9" y="9" width="7" height="7" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="catalog-grid px-10"
            :style="viewMode === 'wide' ? 'grid-template-columns: repeat(2,1fr)' : 'grid-template-columns: repeat(3,1fr)'">

            <template x-if="filtered.length === 0">
                <div class="catalog-empty">No products found</div>
            </template>

            <template x-for="p in filtered" :key="p.id">
                <div class="prod-card">
                    <div class="prod-img-wrap">
                        <img :src="p.image + '?w=400&auto=format'" :alt="p.name" loading="lazy">
                    </div>
                    <div class="prod-info">
                        <p class="prod-brand" x-text="p.categories.length ? p.categories[0] : 'CATEGORY'">
                        </p>
                        <p class="prod-name" x-text="p.name"></p>
                        <div class="prod-price">
                            <span x-text="'Rp ' + p.price.replace(/ /g, '.') + ',00'"></span>
                            <span class="prod-price-label">Harga satuan</span>
                        </div>
                    </div>
                    {{-- Hover quick-actions --}}
                    <div class="prod-actions">
                        <button class="prod-action-btn" @click.stop="addToCart(p.id)">Add to Cart</button>
                        <div class="prod-action-divider"></div>
                        <button class="prod-action-btn" @click.stop="addToWishlist(p.id)"
                            style="flex:0;padding:9px 14px;">♡</button>
                    </div>
                </div>
            </template>

        </div>

        {{-- PAGINATION --}}
        <div class="catalog-pagination px-10">
            <div class="page-btn active">1</div>
            <div class="page-btn">2</div>
            <div class="page-btn">3</div>
            <div class="page-btn">4</div>
            <div class="page-btn">5</div>
            <div class="page-dots">…</div>
            <div class="page-btn">11</div>
            <div style="margin-left:8px; display:flex; gap:2px;">
                <div class="page-btn">‹</div>
                <div class="page-btn">›</div>
            </div>
        </div>

    </div>

    <script>
        function addToCart(id) {
            console.log('Cart:', id);
        }

        function addToWishlist(id) {
            console.log('Wishlist:', id);
        }
    </script>
@endsection
