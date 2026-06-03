@extends('layouts.app')

@section('content')

    @include('pages.home.sections.navbar')

    @php
        // Running products - 35 products
        $runningProducts = [
            // ── NIKE (10) ──
            ['id' => 101, 'brand' => 'Nike', 'name' => 'React Infinity Run',         'filter' => 'Men',   'price' => '13 500', 'image' => 'https://images.unsplash.com/photo-1539185441755-769473a23570'],
            ['id' => 102, 'brand' => 'Nike', 'name' => 'Zoom Pegasus 40',            'filter' => 'Men',   'price' => '11 200', 'image' => 'https://images.unsplash.com/photo-1543508282-6319a3e2621f'],
            ['id' => 103, 'brand' => 'Nike', 'name' => 'Free Run 5.0',               'filter' => 'Men',   'price' => '5 990',  'image' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5'],
            ['id' => 104, 'brand' => 'Nike', 'name' => 'Air Max PULSE',              'filter' => 'Men',   'price' => '11 400', 'image' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2'],
            ['id' => 105, 'brand' => 'Nike', 'name' => 'Nike Vaporfly Next%',        'filter' => 'Women', 'price' => '18 900', 'image' => 'https://images.unsplash.com/photo-1556906781-9a412961a28c'],
            ['id' => 106, 'brand' => 'Nike', 'name' => 'Nike Revolution 7',          'filter' => 'Kids',  'price' => '7 200',  'image' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519'],
            ['id' => 107, 'brand' => 'Nike', 'name' => 'Epic React Flyknit',        'filter' => 'Women', 'price' => '10 800', 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff'],
            ['id' => 108, 'brand' => 'Nike', 'name' => 'Nike Flex Experience',      'filter' => 'Kids',  'price' => '6 500',  'image' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa'],
            ['id' => 109, 'brand' => 'Nike', 'name' => 'Zoom Fly 5',                'filter' => 'Men',   'price' => '15 200', 'image' => 'https://images.unsplash.com/photo-1514996937319-344454492b37'],
            ['id' => 110, 'brand' => 'Nike', 'name' => 'Alphafly Next% 2',          'filter' => 'Women', 'price' => '24 990', 'image' => 'https://images.unsplash.com/photo-1591195853828-11db59a44f6b'],

            // ── ADIDAS (8) ──
            ['id' => 111, 'brand' => 'Adidas', 'name' => 'Ultraboost 22',            'filter' => 'Men',   'price' => '12 990', 'image' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa'],
            ['id' => 112, 'brand' => 'Adidas', 'name' => 'NMD R1 BLACK',             'filter' => 'Men',   'price' => '6 900',  'image' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2'],
            ['id' => 113, 'brand' => 'Adidas', 'name' => 'Adidas Boston 12',         'filter' => 'Men',   'price' => '14 500', 'image' => 'https://images.unsplash.com/photo-1491553895911-0055eca6402d'],
            ['id' => 114, 'brand' => 'Adidas', 'name' => 'Adizero Prime Sprint',    'filter' => 'Women', 'price' => '9 900',  'image' => 'https://images.unsplash.com/photo-1543508282-6319a3e2621f'],
            ['id' => 115, 'brand' => 'Adidas', 'name' => 'Adidas Supernova',         'filter' => 'Women', 'price' => '11 200', 'image' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5'],
            ['id' => 116, 'brand' => 'Adidas', 'name' => 'Adidas Galaxy 7',          'filter' => 'Kids',  'price' => '5 990',  'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff'],
            ['id' => 117, 'brand' => 'Adidas', 'name' => 'Adidas Duramo SL',         'filter' => 'Kids',  'price' => '4 490',  'image' => 'https://images.unsplash.com/photo-1514996937319-344454492b37'],
            ['id' => 118, 'brand' => 'Adidas', 'name' => 'Adidas Adizero Xt',        'filter' => 'Men',   'price' => '16 900', 'image' => 'https://images.unsplash.com/photo-1596032173579-78e38fc89f22'],

            // ── NEW BALANCE (8) ──
            ['id' => 119, 'brand' => 'New Balance', 'name' => 'Sneakers 997 GREY',        'filter' => 'Men',   'price' => '12 900', 'image' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5'],
            ['id' => 120, 'brand' => 'New Balance', 'name' => 'Fresh Foam 1080 V12',     'filter' => 'Men',   'price' => '14 500', 'image' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2'],
            ['id' => 121, 'brand' => 'New Balance', 'name' => 'New Balance 990v5 NAVY',   'filter' => 'Men',   'price' => '13 990', 'image' => 'https://images.unsplash.com/photo-1556906781-9a412961a28c'],
            ['id' => 122, 'brand' => 'New Balance', 'name' => 'Fuelcell Propel V3',       'filter' => 'Women', 'price' => '10 900', 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff'],
            ['id' => 123, 'brand' => 'New Balance', 'name' => 'New Balance 680 V7',       'filter' => 'Women', 'price' => '6 800',  'image' => 'https://images.unsplash.com/photo-1514996937319-344454492b37'],
            ['id' => 124, 'brand' => 'New Balance', 'name' => 'New Balance 519',          'filter' => 'Kids',  'price' => '5 200',  'image' => 'https://images.unsplash.com/photo-1539185441755-769473a23570'],
            ['id' => 125, 'brand' => 'New Balance', 'name' => 'New Balance 570v3',        'filter' => 'Kids',  'price' => '4 800',  'image' => 'https://images.unsplash.com/photo-1543508282-6319a3e2621f'],
            ['id' => 126, 'brand' => 'New Balance', 'name' => 'New Balance FuelCell RC Elite', 'filter' => 'Women', 'price' => '20 900', 'image' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519'],

            // ── PUMA (5) ──
            ['id' => 127, 'brand' => 'Puma', 'name' => 'Softride Enzo',              'filter' => 'Men',   'price' => '4 990',  'image' => 'https://images.unsplash.com/photo-1491553895911-0055eca6402d'],
            ['id' => 128, 'brand' => 'Puma', 'name' => 'Velocity Nitro',             'filter' => 'Men',   'price' => '11 500', 'image' => 'https://images.unsplash.com/photo-1514996937319-344454492b37'],
            ['id' => 129, 'brand' => 'Puma', 'name' => 'Puma Transport',             'filter' => 'Women', 'price' => '8 900',  'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff'],
            ['id' => 130, 'brand' => 'Puma', 'name' => 'Puma Velocity Runner',       'filter' => 'Kids',  'price' => '5 700',  'image' => 'https://images.unsplash.com/photo-1539185441755-769473a23570'],
            ['id' => 131, 'brand' => 'Puma', 'name' => 'Puma Flyer Pro',             'filter' => 'Women', 'price' => '10 200', 'image' => 'https://images.unsplash.com/photo-1543508282-6319a3e2621f'],

            // ── REEBOK (4) ──
            ['id' => 132, 'brand' => 'Reebok', 'name' => 'Floatride Energy 4',       'filter' => 'Men',   'price' => '8 200',  'image' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5'],
            ['id' => 133, 'brand' => 'Reebok', 'name' => 'Nano X3 Training',         'filter' => 'Women', 'price' => '9 900',  'image' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2'],
            ['id' => 134, 'brand' => 'Reebok', 'name' => 'Reebok Flexagon Force 3',  'filter' => 'Kids',  'price' => '6 500',  'image' => 'https://images.unsplash.com/photo-1556906781-9a412961a28c'],
            ['id' => 135, 'brand' => 'Reebok', 'name' => 'Reebok Zoku Runner Legacy', 'filter' => 'Men',   'price' => '7 800',  'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff'],
        ];

        $filters      = ['All', 'Men', 'Women', 'Kids'];
        $brandFilters = ['All Brands', 'Nike', 'Adidas', 'New Balance', 'Puma', 'Reebok'];
        $sorts        = ['Default', 'Price: Low to High', 'Price: High to Low', 'Newest'];
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
            color: #666;
            border: 1.5px solid #ccc;
            border-radius: 20px;
            background: transparent;
            cursor: pointer;
            transition: all .2s;
            letter-spacing: .5px;
            text-transform: uppercase;
        }
        .catalog-filter-chip:hover { border-color: #111; }
        .catalog-filter-chip.active {
            color: #fff;
            background: #111;
            border-color: #111;
        }

        /* ── SORT SELECT ── */
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

        /* ── PRODUCT GRID ── */
        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            padding: 24px 40px;
            border-bottom: 1.5px solid #d0d0d0;
        }

        .prod-card {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        .prod-image-wrap {
            position: relative;
            width: 100%;
            padding-bottom: 100%;
            background: #f5f5f5;
            overflow: hidden;
        }
        .prod-image {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover;
            transition: transform .3s ease;
        }
        .prod-card:hover .prod-image { transform: scale(1.05); }
        .prod-card:hover .prod-actions { opacity: 1; }

        .prod-info {
            padding: 12px 0;
        }
        .prod-brand {
            font-size: 9px;
            font-weight: 600;
            color: #999;
            letter-spacing: .5px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .prod-name {
            font-size: 13px;
            font-weight: 500;
            color: #111;
            letter-spacing: .2px;
        }
        .prod-price {
            font-size: 12px;
            font-weight: 600;
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

        /* ── EMPTY STATE ── */
        .catalog-empty {
            grid-column: span 4;
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
            activeSort: 'Default',
            products: {{ json_encode($runningProducts) }},
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
            <span>Running</span>
        </div>

        {{-- FILTER ROW — CATEGORY & SORT --}}
        <div class="catalog-filter-row">
            @foreach($filters as $f)
                <button
                    class="catalog-filter-chip"
                    @click="activeFilter = '{{ $f }}'"
                    :class="activeFilter === '{{ $f }}' ? 'active' : ''"
                >
                    {{ $f }}
                </button>
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
                    @click="activeBrand = '{{ $b }}'"
                    :class="activeBrand === '{{ $b }}' ? 'active' : ''"
                >
                    {{ $b }}
                </button>
            @endforeach
        </div>

        {{-- PRODUCT GRID --}}
        <div class="catalog-grid">
            <template x-for="product in filtered" :key="product.id">
                <div class="prod-card">
                    <div class="prod-image-wrap">
                        <img :src="product.image" :alt="product.name" class="prod-image">
                        <div class="prod-actions">
                            <button class="prod-action-btn">Add to Bag</button>
                            <div class="prod-action-divider"></div>
                            <button class="prod-action-btn">♡ Save</button>
                        </div>
                    </div>
                    <div class="prod-info">
                        <div class="prod-brand" x-text="product.brand"></div>
                        <div class="prod-name" x-text="product.name"></div>
                        <div class="prod-price">
                            <span x-text="'Rp ' + product.price"></span>
                            <span class="prod-price-label">price</span>
                        </div>
                    </div>
                </div>
            </template>
            <template x-if="filtered.length === 0">
                <div class="catalog-empty">NO PRODUCTS FOUND</div>
            </template>
        </div>

    </div>

@endsection
