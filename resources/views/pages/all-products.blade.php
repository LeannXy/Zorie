@extends('layouts.app')

@section('content')

    @include('pages.home.sections.navbar')

    @php
        $allProducts = [
            // ── NEW BALANCE (10) ──
            ['id' => 1,  'brand' => 'New Balance', 'name' => 'Sneakers 327 BLUE',          'filter' => 'Pria',   'price' => 'Rp99.900',  'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff'],
            ['id' => 2,  'brand' => 'New Balance', 'name' => 'Sneakers ML574 BLACKMATE',   'filter' => 'Pria',   'price' => 'Rp98.900',  'image' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa'],
            ['id' => 3,  'brand' => 'New Balance', 'name' => 'Sneakers 997 GREY BLUE',     'filter' => 'Pria',   'price' => 'Rp129.000', 'image' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5'],
            ['id' => 4,  'brand' => 'New Balance', 'name' => 'Fresh Foam 1080',            'filter' => 'Pria',   'price' => 'Rp145.000', 'image' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2'],
            ['id' => 5,  'brand' => 'New Balance', 'name' => 'Sneakers R1 REDWHITE',       'filter' => 'Wanita', 'price' => 'Rp98.900',  'image' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519'],
            ['id' => 6,  'brand' => 'New Balance', 'name' => 'Sneakers 997 LIGHT PURPLE',  'filter' => 'Wanita', 'price' => 'Rp129.000', 'image' => 'https://images.unsplash.com/photo-1514996937319-344454492b37'],
            ['id' => 7,  'brand' => 'New Balance', 'name' => 'Sneakers 1906R SILVER',      'filter' => 'Wanita', 'price' => 'Rp162.000', 'image' => 'https://images.unsplash.com/photo-1582588678413-dbf45f4823e9'],
            ['id' => 8,  'brand' => 'New Balance', 'name' => 'Sneakers 550 WHITE GREEN',   'filter' => 'Anak-anak',  'price' => 'Rp114.000', 'image' => 'https://images.unsplash.com/photo-1539185441755-769473a23570'],
            ['id' => 9,  'brand' => 'New Balance', 'name' => 'Sneakers 2002R GREY',        'filter' => 'Diskon',  'price' => 'Rp85.000',  'image' => 'https://images.unsplash.com/photo-1491553895911-0055eca6402d'],
            ['id' => 10, 'brand' => 'New Balance', 'name' => 'Sneakers 990v5 NAVY',        'filter' => 'Diskon',  'price' => 'Rp139.900', 'image' => 'https://images.unsplash.com/photo-1556906781-9a412961a28c'],

            // -- ADIDAS (10) --
            ['id' => 11, 'brand' => 'Adidas',      'name' => 'Yung-1 NEON',                'filter' => 'Pria',   'price' => 'Rp42.450',  'image' => 'https://images.unsplash.com/photo-1543508282-6319a3e2621f'],
            ['id' => 12, 'brand' => 'Adidas',      'name' => '8K Suede GREY',              'filter' => 'Pria',   'price' => 'Rp42.450',  'image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77'],
            ['id' => 13, 'brand' => 'Adidas',      'name' => 'Yung-1 BLACK',               'filter' => 'Pria',   'price' => 'Rp42.450',  'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772'],
            ['id' => 14, 'brand' => 'Adidas',      'name' => 'LXCON GREY',                 'filter' => 'Wanita', 'price' => 'Rp69.950',  'image' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a'],
            ['id' => 15, 'brand' => 'Adidas',      'name' => 'Ozweego LILAC',              'filter' => 'Wanita', 'price' => 'Rp84.900',  'image' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5'],
            ['id' => 16, 'brand' => 'Adidas',      'name' => 'Ultraboost 22',              'filter' => 'Pria',   'price' => 'Rp129.900', 'image' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa'],
            ['id' => 17, 'brand' => 'Adidas',      'name' => 'Forum Low WHITE',            'filter' => 'Anak-anak',  'price' => 'Rp72.000',  'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff'],
            ['id' => 18, 'brand' => 'Adidas',      'name' => 'NMD R1 BLACK',               'filter' => 'Diskon',  'price' => 'Rp69.000',  'image' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2'],
            ['id' => 19, 'brand' => 'Adidas',      'name' => 'Gazelle BLUE',               'filter' => 'Wanita', 'price' => 'Rp64.900',  'image' => 'https://images.unsplash.com/photo-1491553895911-0055eca6402d'],
            ['id' => 20, 'brand' => 'Adidas',      'name' => 'Samba OG WHITE',             'filter' => 'Diskon',  'price' => 'Rp59.900',  'image' => 'https://images.unsplash.com/photo-1514996937319-344454492b37'],

            // -- NIKE (10) --
            ['id' => 21, 'brand' => 'Nike',        'name' => 'Air Max 90 WHITE',           'filter' => 'Pria',   'price' => 'Rp119.900', 'image' => 'https://images.unsplash.com/photo-1556906781-9a412961a28c'],
            ['id' => 22, 'brand' => 'Nike',        'name' => 'Air Force 1 LOW',            'filter' => 'Pria',   'price' => 'Rp99.900',  'image' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519'],
            ['id' => 23, 'brand' => 'Nike',        'name' => 'React Infinity Run',         'filter' => 'Wanita', 'price' => 'Rp135.000', 'image' => 'https://images.unsplash.com/photo-1539185441755-769473a23570'],
            ['id' => 24, 'brand' => 'Nike',        'name' => 'Zoom Pegasus 40',            'filter' => 'Pria',   'price' => 'Rp112.000', 'image' => 'https://images.unsplash.com/photo-1543508282-6319a3e2621f'],
            ['id' => 25, 'brand' => 'Nike',        'name' => 'Dunk Low PANDA',             'filter' => 'Pria',   'price' => 'Rp148.000', 'image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77'],
            ['id' => 26, 'brand' => 'Nike',        'name' => 'Blazer Mid 77',              'filter' => 'Wanita', 'price' => 'Rp84.900',  'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772'],
            ['id' => 27, 'brand' => 'Nike',        'name' => 'Air Jordan 1 LOW',           'filter' => 'Anak-anak',  'price' => 'Rp169.000', 'image' => 'https://images.unsplash.com/photo-1582588678413-dbf45f4823e9'],
            ['id' => 28, 'brand' => 'Nike',        'name' => 'Free Run 5.0',               'filter' => 'Diskon',  'price' => 'Rp59.900',  'image' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5'],
            ['id' => 29, 'brand' => 'Nike',        'name' => 'Court Vision LOW',           'filter' => 'Anak-anak',  'price' => 'Rp62.000',  'image' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a'],
            ['id' => 30, 'brand' => 'Nike',        'name' => 'Air Max PULSE',              'filter' => 'Diskon',  'price' => 'Rp114.000', 'image' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2'],

            // -- PUMA (8) --
            ['id' => 31, 'brand' => 'Puma',        'name' => 'RS-X³ PUZZLE',               'filter' => 'Pria',   'price' => 'Rp59.900',  'image' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa'],
            ['id' => 32, 'brand' => 'Puma',        'name' => 'Suede Classic XXI',          'filter' => 'Wanita', 'price' => 'Rp54.900',  'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff'],
            ['id' => 33, 'brand' => 'Puma',        'name' => 'Speedcat OG',                'filter' => 'Pria',   'price' => 'Rp67.900',  'image' => 'https://images.unsplash.com/photo-1556906781-9a412961a28c'],
            ['id' => 34, 'brand' => 'Puma',        'name' => 'Softride Enzo',              'filter' => 'Anak-anak',  'price' => 'Rp49.900',  'image' => 'https://images.unsplash.com/photo-1491553895911-0055eca6402d'],
            ['id' => 35, 'brand' => 'Puma',        'name' => 'Clyde All Pro',              'filter' => 'Pria',   'price' => 'Rp72.000',  'image' => 'https://images.unsplash.com/photo-1514996937319-344454492b37'],
            ['id' => 36, 'brand' => 'Puma',        'name' => 'Future Rider',               'filter' => 'Wanita', 'price' => 'Rp51.000',  'image' => 'https://images.unsplash.com/photo-1539185441755-769473a23570'],
            ['id' => 37, 'brand' => 'Puma',        'name' => 'Nitro Elite',                'filter' => 'Diskon',  'price' => 'Rp78.000',  'image' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519'],
            ['id' => 38, 'brand' => 'Puma',        'name' => 'MB.02 LaMelo',               'filter' => 'Anak-anak',  'price' => 'Rp109.900', 'image' => 'https://images.unsplash.com/photo-1582588678413-dbf45f4823e9'],

            // -- REEBOK (7) --
            ['id' => 39, 'brand' => 'Reebok',      'name' => 'Classic Leather',            'filter' => 'Pria',   'price' => 'Rp64.900',  'image' => 'https://images.unsplash.com/photo-1543508282-6319a3e2621f'],
            ['id' => 40, 'brand' => 'Reebok',      'name' => 'Nano X3',                    'filter' => 'Pria',   'price' => 'Rp99.000',  'image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77'],
            ['id' => 41, 'brand' => 'Reebok',      'name' => 'Club C 85 WHITE',            'filter' => 'Wanita', 'price' => 'Rp59.900',  'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772'],
            ['id' => 42, 'brand' => 'Reebok',      'name' => 'Floatride Energy',           'filter' => 'Wanita', 'price' => 'Rp82.000',  'image' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5'],
            ['id' => 43, 'brand' => 'Reebok',      'name' => 'Freestyle Hi',               'filter' => 'Anak-anak',  'price' => 'Rp74.900',  'image' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a'],
            ['id' => 44, 'brand' => 'Reebok',      'name' => 'Zig Kinetica',               'filter' => 'Diskon',  'price' => 'Rp69.900',  'image' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2'],
            ['id' => 45, 'brand' => 'Reebok',      'name' => 'Pump Omni Zone',             'filter' => 'Diskon',  'price' => 'Rp82.000',  'image' => 'https://images.unsplash.com/photo-1556906781-9a412961a28c'],
        ];

        $filters      = ['Semua', 'Pria', 'Wanita', 'Anak-anak', 'Diskon'];
        $brandFilters = ['Semua Brand', 'New Balance', 'Adidas', 'Nike', 'Puma', 'Reebok'];
        $sorts        = ['Default', 'Harga: Terendah ke Tertinggi', 'Harga: Tertinggi ke Terendah', 'Terbaru'];
    @endphp

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;600;700&family=Barlow+Condensed:wght@400;500;600;700&display=swap');

        .catalog-wrap * { font-family: 'Barlow', sans-serif; }

        .catalog-wrap { background: #fff; min-height: 100vh; padding-top: 80px; }

        /* ── BREADCRUMB ── */
        .catalog-breadcrumb {
            padding: 12px 40px;
            font-size: 11px;
            color: #999;
            letter-spacing: .5px;
            border-bottom: 1.5px solid #d0d0d0;
        }
        .catalog-breadcrumb a { color: #999; text-decoration: none; }
        .catalog-breadcrumb a:hover { color: #111; }

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
        .catalog-filter-chip:hover { border-color: #111; color: #111; }
        .catalog-filter-chip.active { background: #111; color: #fff; border-color: #111; }

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
        .catalog-sort-wrap { display: flex; align-items: center; gap: 14px; }
        .catalog-view-btn {
            width: 26px; height: 26px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: #bbb; transition: color .15s;
        }
        .catalog-view-btn:hover, .catalog-view-btn.active { color: #111; }
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
        .prod-card:hover { background: #fafafa; }
        .prod-card:hover .prod-actions { opacity: 1; transform: translateY(0); }

        .prod-img-wrap {
            background: #f6f6f6;
            height: 210px;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
            position: relative;
            border-bottom: 1.5px solid #d0d0d0;
        }
        .prod-img-wrap img {
            width: 160px; height: 160px;
            object-fit: contain;
            transition: transform .35s cubic-bezier(.25,.46,.45,.94);
        }
        .prod-card:hover .prod-img-wrap img { transform: scale(1.06); }

        .prod-info { padding: 12px 14px 14px; }
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
            bottom: 0; left: 0; right: 0;
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
        .prod-action-btn:hover { background: #333; }
        .prod-action-divider { width: 1.5px; background: #333; }

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
            width: 28px; height: 28px;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 500; color: #888;
            border: 1.5px solid transparent;
            cursor: pointer; transition: all .15s;
        }
        .page-btn:hover { color: #111; border-color: #bbb; }
        .page-btn.active { color: #111; border-color: #111; font-weight: 700; }
        .page-dots { font-size: 11px; color: #ccc; padding: 0 4px; }

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

    <div class="catalog-wrap"
         x-data="{
            activeFilter: 'All',
            activeBrand: 'All Brands',
            activeSort: 'По умолчанию',
            viewMode: 'grid',
            products: {{ json_encode($allProducts) }},
            get filtered() {
                let p = this.products;
                if (this.activeFilter !== 'All')       p = p.filter(x => x.filter === this.activeFilter);
                if (this.activeBrand !== 'All Brands') p = p.filter(x => x.brand === this.activeBrand);
                if (this.activeSort === 'Price: Low to High') p = [...p].sort((a,b) => parseInt(a.price.replace(/\s/g,'')) - parseInt(b.price.replace(/\s/g,'')));
                if (this.activeSort === 'Price: High to Low') p = [...p].sort((a,b) => parseInt(b.price.replace(/\s/g,'')) - parseInt(a.price.replace(/\s/g,'')));
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
            @foreach($filters as $f)
                <button
                    class="catalog-filter-chip"
                    :class="{ 'active': activeFilter === '{{ $f }}' }"
                    @click="activeFilter = '{{ $f }}'"
                >{{ $f }}</button>
            @endforeach
            <div style="flex:1"></div>
            <select class="catalog-sort-select" x-model="activeSort">
                @foreach($sorts as $s)
                    <option>{{ $s }}</option>
                @endforeach
            </select>
        </div>

        {{-- FILTER ROW — BRAND --}}
        <div class="catalog-filter-row" style="border-top:none; padding-top:8px; padding-bottom:8px; gap:4px;">
            @foreach($brandFilters as $b)
                <button
                    class="catalog-filter-chip"
                    style="border-radius:50px; font-size:10px;"
                    :class="{ 'active': activeBrand === '{{ $b }}' }"
                    @click="activeBrand = '{{ $b }}'"
                >{{ $b }}</button>
            @endforeach
        </div>

        {{-- TOOLBAR --}}
        <div class="catalog-toolbar">
            <p class="catalog-count">
                Showing: <span x-text="filtered.length"></span> products
            </p>
            <div class="catalog-sort-wrap">
                {{-- Grid icons --}}
                <div class="catalog-view-btn" :class="{active: viewMode==='grid'}" @click="viewMode='grid'" title="3 col">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <rect x="0" y="0" width="4" height="4"/><rect x="6" y="0" width="4" height="4"/>
                        <rect x="12" y="0" width="4" height="4"/><rect x="0" y="6" width="4" height="4"/>
                        <rect x="6" y="6" width="4" height="4"/><rect x="12" y="6" width="4" height="4"/>
                        <rect x="0" y="12" width="4" height="4"/><rect x="6" y="12" width="4" height="4"/>
                        <rect x="12" y="12" width="4" height="4"/>
                    </svg>
                </div>
                <div class="catalog-view-btn" :class="{active: viewMode==='wide'}" @click="viewMode='wide'" title="2 col">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <rect x="0" y="0" width="7" height="7"/><rect x="9" y="0" width="7" height="7"/>
                        <rect x="0" y="9" width="7" height="7"/><rect x="9" y="9" width="7" height="7"/>
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
                        <p class="prod-brand" x-text="p.brand"></p>
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
                        <button class="prod-action-btn" @click.stop="addToWishlist(p.id)" style="flex:0;padding:9px 14px;">♡</button>
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
        function addToCart(id)      { console.log('Cart:', id); }
        function addToWishlist(id)  { console.log('Wishlist:', id); }
    </script>

@endsection