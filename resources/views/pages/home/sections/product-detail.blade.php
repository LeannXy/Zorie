@extends('layouts.app')

@section('content')
    @include('pages.home.sections.navbar')

    @php
        $navbarCustomer = session('customer_id') ? \App\Models\CustomerAccount::find(session('customer_id')) : null;
    @endphp

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400&display=swap');

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        .pd-wrap {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f5f5f3;
            min-height: 100vh;
        }

        /* ─── SCROLLBAR ─── */
        .pd-thumb-rail::-webkit-scrollbar {
            width: 3px;
        }

        .pd-thumb-rail::-webkit-scrollbar-track {
            background: transparent;
        }

        .pd-thumb-rail::-webkit-scrollbar-thumb {
            background: #000039/20;
            border-radius: 99px;
        }

        /* ─── BREADCRUMB ─── */
        .pd-breadcrumb {
            max-width: 1280px;
            margin: 0 auto;
            padding: clamp(12px, 2vw, 20px) clamp(16px, 4vw, 40px);
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: rgba(0, 0, 57, .4);
            letter-spacing: .4px;
        }

        .pd-breadcrumb a {
            color: rgba(0, 0, 57, .4);
            text-decoration: none;
            transition: color .15s;
        }

        .pd-breadcrumb a:hover {
            color: #000039;
        }

        .pd-breadcrumb-sep {
            opacity: .3;
        }

        /* ─── MAIN LAYOUT ─── */
        .pd-main {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 clamp(16px, 4vw, 40px) clamp(40px, 6vw, 80px);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: clamp(24px, 4vw, 64px);
            align-items: start;
        }

        /* ─── GALLERY ─── */
        .pd-gallery {
            position: sticky;
            top: 88px;
        }

        .pd-main-img-wrap {
            background: #ebebea;
            border-radius: 16px;
            aspect-ratio: 1;
            overflow: hidden;
            position: relative;
            cursor: zoom-in;
        }

        .pd-main-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform .5s cubic-bezier(.25, .46, .45, .94), opacity .3s;
            padding: 24px;
        }

        .pd-main-img-wrap:hover img {
            transform: scale(1.05);
        }

        .pd-zoom-hint {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(255, 255, 255, .7);
            backdrop-filter: blur(8px);
            border-radius: 99px;
            padding: 5px 10px;
            font-size: 10px;
            font-weight: 600;
            color: #000039;
            letter-spacing: .5px;
            opacity: 0;
            transition: opacity .2s;
            pointer-events: none;
        }

        .pd-main-img-wrap:hover .pd-zoom-hint {
            opacity: 1;
        }

        .pd-img-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .pd-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .pd-badge-new {
            background: #000039;
            color: #fff;
        }

        .pd-badge-sale {
            background: #e63;
            color: #fff;
        }

        .pd-thumb-row {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            overflow-x: auto;
            scrollbar-width: none;
            padding-bottom: 2px;
        }

        .pd-thumb-row::-webkit-scrollbar {
            display: none;
        }

        .pd-thumb {
            flex-shrink: 0;
            width: clamp(56px, 8vw, 72px);
            height: clamp(56px, 8vw, 72px);
            background: #ebebea;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color .2s, transform .2s;
        }

        .pd-thumb:hover {
            transform: translateY(-2px);
        }

        .pd-thumb.active {
            border-color: #000039;
        }

        .pd-thumb img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 6px;
        }

        /* ─── INFO PANEL ─── */
        .pd-info {
            padding-top: 4px;
        }

        .pd-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 600;
            color: rgba(0, 0, 57, .5);
            text-decoration: none;
            letter-spacing: .3px;
            margin-bottom: 16px;
            transition: color .15s;
        }

        .pd-back-btn:hover {
            color: #000039;
        }

        .pd-category-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 99px;
            border: 1.5px solid rgba(0, 0, 57, .15);
            background: rgba(0, 0, 57, .04);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(0, 0, 57, .5);
            margin-bottom: 12px;
        }

        .pd-product-name {
            font-size: clamp(24px, 3.5vw, 40px);
            font-weight: 900;
            color: #000039;
            letter-spacing: clamp(-1px, -.15vw, -2px);
            line-height: 1.05;
            margin-bottom: 8px;
        }

        .pd-rating-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .pd-stars {
            display: flex;
            gap: 2px;
        }

        .pd-star {
            color: #f5a623;
            font-size: 13px;
        }

        .pd-star-empty {
            color: #d0d0d0;
            font-size: 13px;
        }

        .pd-rating-count {
            font-size: 11px;
            color: rgba(0, 0, 57, .45);
            font-weight: 500;
        }

        .pd-price-row {
            display: flex;
            align-items: baseline;
            gap: 10px;
            margin-bottom: 20px;
        }

        .pd-price {
            font-size: clamp(22px, 3vw, 32px);
            font-weight: 900;
            color: #000039;
            letter-spacing: -1px;
        }

        .pd-price-original {
            font-size: 14px;
            color: rgba(0, 0, 57, .35);
            text-decoration: line-through;
            font-weight: 500;
        }

        .pd-discount-pill {
            padding: 2px 8px;
            border-radius: 99px;
            background: #e63;
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .5px;
        }

        .pd-divider {
            border: none;
            border-top: 1.5px solid rgba(0, 0, 57, .08);
            margin: 20px 0;
        }

        /* ── SIZE SELECTOR ── */
        .pd-section-label {
            font-size: 11px;
            font-weight: 700;
            color: rgba(0, 0, 57, .4);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .pd-size-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-bottom: 6px;
        }

        .pd-size-btn {
            min-width: 48px;
            height: 44px;
            padding: 0 12px;
            border: 1.5px solid rgba(0, 0, 57, .15);
            border-radius: 10px;
            background: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: rgba(0, 0, 57, .6);
            cursor: pointer;
            transition: all .15s;
            position: relative;
        }

        .pd-size-btn:hover:not(.sold-out) {
            border-color: #000039;
            color: #000039;
        }

        .pd-size-btn.active {
            background: #000039;
            color: #fff;
            border-color: #000039;
        }

        .pd-size-btn.sold-out {
            color: rgba(0, 0, 57, .2);
            border-color: rgba(0, 0, 57, .08);
            cursor: not-allowed;
            background: rgba(0, 0, 57, .02);
        }

        .pd-size-btn.sold-out::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 8px;
            right: 8px;
            height: 1px;
            background: rgba(0, 0, 57, .15);
            transform: rotate(-12deg);
        }

        .pd-stock-info {
            min-height: 22px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 6px;
            transition: all .2s;
        }

        .pd-stock-ok {
            color: #22a06b;
        }

        .pd-stock-low {
            color: #e8702a;
        }

        .pd-stock-out {
            color: rgba(0, 0, 57, .35);
        }

        /* ── QTY ── */
        .pd-qty-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 20px;
        }

        .pd-qty-wrap {
            display: flex;
            align-items: center;
            border: 1.5px solid rgba(0, 0, 57, .15);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }

        .pd-qty-btn {
            width: 40px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 300;
            color: rgba(0, 0, 57, .5);
            cursor: pointer;
            border: none;
            background: transparent;
            transition: background .15s, color .15s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .pd-qty-btn:hover {
            background: rgba(0, 0, 57, .06);
            color: #000039;
        }

        .pd-qty-num {
            min-width: 44px;
            text-align: center;
            font-size: 14px;
            font-weight: 700;
            color: #000039;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .pd-qty-label {
            font-size: 11px;
            color: rgba(0, 0, 57, .4);
            font-weight: 500;
        }

        /* ── ACTION BTNS ── */
        .pd-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .pd-btn {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px;
            font-weight: 700;
            border-radius: 12px;
            cursor: pointer;
            transition: all .2s;
            letter-spacing: .3px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .pd-btn-checkout {
            flex: 2;
            padding: 14px 20px;
            background: #000039;
            color: #fff;
            border: none;
        }

        .pd-btn-checkout:hover {
            background: rgba(0, 0, 57, .85);
            transform: translateY(-1px);
        }

        .pd-btn-checkout:active {
            transform: translateY(0);
        }

        .pd-btn-cart {
            flex: 1;
            padding: 14px 16px;
            background: #fff;
            color: #000039;
            border: 1.5px solid rgba(0, 0, 57, .2);
        }

        .pd-btn-cart:hover {
            border-color: #000039;
            background: rgba(0, 0, 57, .04);
        }

        .pd-btn-wishlist {
            width: 50px;
            height: 50px;
            padding: 0;
            background: #fff;
            color: rgba(0, 0, 57, .5);
            border: 1.5px solid rgba(0, 0, 57, .15);
        }

        .pd-btn-wishlist:hover {
            border-color: #e63;
            color: #e63;
        }

        .pd-btn-wishlist.wishlisted {
            background: #fff0ee;
            color: #e63;
            border-color: #e63;
        }

        .pd-btn-chat {
            width: 100%;
            margin-top: 10px;
            padding: 13px;
            background: #f0f4ff;
            color: #000039;
            border: 1.5px solid rgba(0, 0, 57, .12);
            font-size: 12px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all .15s;
        }

        .pd-btn-chat:hover {
            background: rgba(0, 0, 57, .08);
            border-color: #000039;
        }

        /* ── DESCRIPTION ── */
        .pd-desc-section {
            margin-top: 24px;
        }

        .pd-desc-text {
            font-size: 13px;
            line-height: 1.75;
            color: rgba(0, 0, 57, .6);
            font-weight: 400;
        }

        .pd-specs-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 14px;
        }

        .pd-spec-item {
            background: #fff;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 57, .08);
            padding: 10px 14px;
        }

        .pd-spec-key {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(0, 0, 57, .35);
            margin-bottom: 2px;
        }

        .pd-spec-val {
            font-size: 12px;
            font-weight: 600;
            color: #000039;
        }

        /* ─── REVIEWS ─── */
        .pd-reviews-section {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 clamp(16px, 4vw, 40px) clamp(40px, 6vw, 64px);
        }

        .pd-section-title {
            font-size: clamp(18px, 2.5vw, 26px);
            font-weight: 900;
            color: #000039;
            letter-spacing: -1px;
            margin-bottom: 20px;
        }

        .pd-review-summary {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 32px;
            align-items: center;
            background: #fff;
            border-radius: 16px;
            padding: 24px 28px;
            border: 1px solid rgba(0, 0, 57, .08);
            margin-bottom: 20px;
        }

        .pd-avg-score {
            font-size: 56px;
            font-weight: 900;
            color: #000039;
            line-height: 1;
            letter-spacing: -3px;
        }

        .pd-avg-label {
            font-size: 11px;
            color: rgba(0, 0, 57, .4);
            font-weight: 500;
        }

        .pd-bar-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
        }

        .pd-bar-label {
            font-size: 10px;
            font-weight: 700;
            color: rgba(0, 0, 57, .5);
            width: 14px;
            text-align: right;
        }

        .pd-bar-track {
            flex: 1;
            height: 5px;
            background: rgba(0, 0, 57, .08);
            border-radius: 99px;
            overflow: hidden;
        }

        .pd-bar-fill {
            height: 100%;
            background: #000039;
            border-radius: 99px;
        }

        .pd-bar-count {
            font-size: 10px;
            color: rgba(0, 0, 57, .35);
            width: 20px;
        }

        .pd-review-filters {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .pd-filter-chip {
            padding: 6px 14px;
            border-radius: 99px;
            border: 1.5px solid rgba(0, 0, 57, .15);
            font-size: 11px;
            font-weight: 600;
            color: rgba(0, 0, 57, .55);
            cursor: pointer;
            background: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all .15s;
        }

        .pd-filter-chip:hover {
            border-color: #000039;
            color: #000039;
        }

        .pd-filter-chip.active {
            background: #000039;
            color: #fff;
            border-color: #000039;
        }

        .pd-review-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .pd-review-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 57, .08);
            padding: 18px 20px;
        }

        .pd-review-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 10px;
        }

        .pd-reviewer-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #000039;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .pd-reviewer-name {
            font-size: 13px;
            font-weight: 700;
            color: #000039;
        }

        .pd-review-date {
            font-size: 10px;
            color: rgba(0, 0, 57, .35);
            margin-top: 2px;
        }

        .pd-review-text {
            font-size: 13px;
            line-height: 1.65;
            color: rgba(0, 0, 57, .65);
        }

        .pd-review-tag {
            display: inline-flex;
            margin-top: 10px;
            padding: 3px 10px;
            border-radius: 99px;
            background: rgba(0, 0, 57, .05);
            border: 1px solid rgba(0, 0, 57, .08);
            font-size: 10px;
            font-weight: 600;
            color: rgba(0, 0, 57, .45);
        }

        .pd-verified {
            font-size: 10px;
            color: #22a06b;
            font-weight: 600;
        }

        /* ─── RECOMMENDATIONS ─── */
        .pd-reco-section {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 clamp(16px, 4vw, 40px) clamp(48px, 8vw, 80px);
        }

        .pd-reco-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .pd-reco-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 57, .08);
            overflow: hidden;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
            text-decoration: none;
        }

        .pd-reco-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0, 0, 57, .1);
        }

        .pd-reco-img {
            background: #ebebea;
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid rgba(0, 0, 57, .06);
        }

        .pd-reco-img img {
            width: 80%;
            height: 80%;
            object-fit: contain;
            padding: 16px;
            transition: transform .35s;
        }

        .pd-reco-card:hover .pd-reco-img img {
            transform: scale(1.06);
        }

        .pd-reco-body {
            padding: 12px 14px 14px;
        }

        .pd-reco-cat {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: rgba(0, 0, 57, .35);
        }

        .pd-reco-name {
            font-size: 12px;
            font-weight: 700;
            color: #000039;
            margin-top: 3px;
            line-height: 1.35;
        }

        .pd-reco-price {
            font-size: 13px;
            font-weight: 800;
            color: #000039;
            margin-top: 6px;
        }

        /* ─── ZOOM MODAL ─── */
        .pd-zoom-modal {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0, 0, 57, .7);
            backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .pd-zoom-modal img {
            max-width: 90vw;
            max-height: 85vh;
            object-fit: contain;
            border-radius: 16px;
            background: #fff;
        }

        .pd-zoom-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 44px;
            height: 44px;
            border: 2px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            cursor: pointer;
            background: rgba(255, 255, 255, .1);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 20px;
            font-weight: 300;
            transition: background .15s;
        }

        .pd-zoom-close:hover {
            background: rgba(255, 255, 255, .25);
        }

        /* ─── MOBILE ─── */
        @media (max-width: 768px) {
            .pd-main {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .pd-gallery {
                position: static;
            }

            .pd-reco-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .pd-review-summary {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .pd-specs-grid {
                grid-template-columns: 1fr;
            }

            .pd-actions {
                flex-wrap: wrap;
            }

            .pd-btn-checkout {
                flex: 1 1 100%;
                order: -1;
            }
        }

        @media (max-width: 480px) {
            .pd-reco-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
        }
    </style>
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
            class="
    fixed
    top-24
    right-5
    z-[9999]
    flex
    items-center
    gap-3
    rounded-2xl
    border
    border-green-200
    bg-white
    px-5
    py-4
    shadow-xl">

            <div
                class="
        flex
        h-10
        w-10
        items-center
        justify-center
        rounded-full
        bg-green-100">

                <i data-lucide="check" class="
            h-5
            w-5
            text-green-600">
                </i>

            </div>

            <div>

                <p class="
            text-sm
            font-semibold
            text-zinc-900">

                    Berhasil

                </p>

                <p class="
            text-sm
            text-zinc-500">

                    {{ session('success') }}

                </p>

            </div>

        </div>
    @endif

    {{-- <div class="pd-wrap" x-data="{
        isLoggedIn: {{ session('customer_id') ? 'true' : 'false' }},
        activeImg: 0,
        images: @js($product->images->map(fn($i) => asset('storage/' . $i->image))->values()),
        selectedSize: null,
        qty: 1,
        wishlisted: false,
        zoomOpen: false, --}}


    <div class="pd-wrap" x-data="{
        isLoggedIn: {{ session('customer_id') ? 'true' : 'false' }},
        activeImg: 0,
        images: @js($product->images->map(fn($i) => asset('storage/' . $i->image))->values()),
        selectedSize: null,
        showSizeWarning: false,
        errorToast: false,
        errorMsg: '',
        triggerError(msg) {
            this.errorMsg = msg;
            this.errorToast = true;
            this.showSizeWarning = true;
            setTimeout(() => { this.errorToast = false }, 3000);
            document.querySelector('.pd-size-grid').scrollIntoView({ behavior: 'smooth', block: 'center' });
        },
        qty: 1,
        wishlisted: false,
        zoomOpen: false,
        stockData: @js($product->sizes ?? collect()),
        reviewFilter: 'Semua',
    
    
        get activeImgUrl() {
            return this.images.length ? this.images[this.activeImg] : '';
        },
        get selectedStock() {
            if (!this.selectedSize) return null;
            const s = this.stockData.find(x => x.size == this.selectedSize);
            return s ? s.stock : 0;
        },
        incQty() {
            if (this.selectedStock !== null && this.qty < this.selectedStock) this.qty++;
            else if (this.selectedStock === null) this.qty++;
        },
        decQty() { if (this.qty > 1) this.qty--; }
    }">

        {{-- Error Toast --}}
        <div x-show="errorToast" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed top-24 right-5 z-[9999] flex items-center gap-3 rounded-2xl border border-red-200 bg-white px-5 py-4 shadow-xl"
            style="display: none;">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-50">
                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-zinc-900">Perhatian</p>
                <p class="text-sm text-zinc-500" x-text="errorMsg"></p>
            </div>
        </div>

        {{-- ── BREADCRUMB ── --}}
        <div class="pd-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="pd-breadcrumb-sep">›</span>
            <a href="{{ route('all-products') }}">Semua Produk</a>
            <span class="pd-breadcrumb-sep">›</span>
            <span style="color:rgba(0,0,57,.7); font-weight:600;">{{ $product->name }}</span>
        </div>

        {{-- ── MAIN GRID ── --}}
        <div class="pd-main">

            {{-- ════ GALLERY ════ --}}
            <div class="pd-gallery">

                {{-- Main Image --}}
                <div class="pd-main-img-wrap" @click="zoomOpen = true">
                    <template x-if="images.length">
                        <img :src="activeImgUrl" :alt="'{{ $product->name }}'" x-key="activeImg">
                    </template>
                    <template x-if="!images.length">
                        <div
                            style="display:flex;align-items:center;justify-content:center;height:100%;color:rgba(0,0,57,.2);font-size:13px;">
                            Tidak ada gambar
                        </div>
                    </template>

                    {{-- Badges --}}
                    <div class="pd-img-badge">
                        {{-- @if ($product->is_new ?? false) --}}
                        <span class="pd-badge pd-badge-new">New</span>
                        {{-- @endif --}}
                        @if ($product->discount)
                            <span class="pd-badge pd-badge-sale">-{{ $product->discount }}%</span>
                        @endif
                    </div>

                    <span class="pd-zoom-hint">🔍 Klik untuk zoom</span>
                </div>

                {{-- Thumbnails --}}
                <div class="pd-thumb-row">
                    <template x-for="(img, i) in images" :key="i">
                        <div class="pd-thumb" :class="{ active: activeImg === i }" @click="activeImg = i">
                            <img :src="img" alt="">
                        </div>
                    </template>
                </div>

            </div>

            {{-- ════ INFO ════ --}}
            <div class="pd-info">

                {{-- Back --}}
                <a href="{{ route('all-products') }}" class="pd-back-btn">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 5l-7 7 7 7" />
                    </svg>
                    Kembali ke Semua Produk
                </a>

                {{-- Category Tag --}}
                <div class="pd-category-tag">
                    <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    {{ $product->categories->first()?->name ?? 'Produk' }}
                </div>

                {{-- Name --}}
                <h1 class="pd-product-name">{{ $product->name }}</h1>

                {{-- Rating --}}
                <div class="pd-rating-row">
                    <div class="pd-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <span
                                class="{{ $i <= round($product->reviews?->avg('rating') ?? 4.5) ? 'pd-star' : 'pd-star-empty' }}">★</span>
                        @endfor
                    </div>
                    <span class="pd-rating-count">
                        {{ number_format($product->reviews?->avg('rating') ?? 4.5, 1) }}
                        ({{ $product->reviews?->count() ?? 0 }} ulasan)
                    </span>
                    @if (($product->sold_count ?? 0) > 0)
                        <span style="font-size:10px;color:rgba(0,0,57,.3);">·</span>
                        <span
                            style="font-size:11px;color:rgba(0,0,57,.4);font-weight:500;">{{ number_format($product->sold_count) }}
                            terjual</span>
                    @endif
                </div>

                {{-- Price --}}
                <div class="pd-price-row">
                    <span class="pd-price">
                        Rp{{ number_format(
                            $product->discount ? $product->price * (1 - $product->discount / 100) : $product->price,
                            0,
                            ',',
                            '.',
                        ) }}
                    </span>
                    @if ($product->discount)
                        <span class="pd-price-original">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="pd-discount-pill">-{{ $product->discount }}%</span>
                    @endif
                </div>

                <hr class="pd-divider">

                {{-- Size Selector --}}
                <div>
                    <p class="pd-section-label">Ukuran Sepatu</p>
                    <div class="pd-size-grid"
                        :class="{
                            'ring-2 ring-red-400 rounded-xl p-2': showSizeWarning
                        }">
                        @foreach ($product->sizes ?? [] as $sizeObj)
                            <button class="pd-size-btn {{ $sizeObj->stock == 0 ? 'sold-out' : '' }}"
                                :class="{
                                    'active': selectedSize === '{{ $sizeObj->size }}',
                                    'sold-out': {{ $sizeObj->stock == 0 ? 'true' : 'false' }}
                                }"
                                @click="
selectedSize='{{ $sizeObj->size }}';
showSizeWarning=false;
qty=1
"
                                {{ $sizeObj->stock == 0 ? 'disabled' : '' }}>
                                {{ $sizeObj->size }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Stock Info --}}
                    <p class="pd-stock-info"
                        :class="{
                            'pd-stock-ok': selectedStock > 5,
                            'pd-stock-low': selectedStock > 0 && selectedStock <= 5,
                            'pd-stock-out': selectedStock === 0
                        }">
                        <template x-if="selectedSize === null">
                            <span style="color:rgba(0,0,57,.3);">↑ Pilih ukuran terlebih dahulu</span>
                        </template>
                        <template x-if="selectedSize !== null && selectedStock > 5">
                            <span>✓ Stok tersedia (<span x-text="selectedStock"></span> unit)</span>
                        </template>
                        <template x-if="selectedSize !== null && selectedStock > 0 && selectedStock <= 5">
                            <span>⚡ Stok terbatas — hanya <span x-text="selectedStock"></span> unit!</span>
                        </template>
                        <template x-if="selectedSize !== null && selectedStock === 0">
                            <span>✗ Ukuran ini habis</span>
                        </template>
                    </p>
                </div>

                <hr class="pd-divider">

                {{-- Qty --}}
                <div class="pd-qty-row">
                    <div class="pd-qty-wrap">
                        <button class="pd-qty-btn" @click="decQty">−</button>
                        <span class="pd-qty-num" x-text="qty"></span>
                        <button class="pd-qty-btn" @click="incQty">+</button>
                    </div>
                    <span class="pd-qty-label">
                        <template x-if="qty > 1">
                            <span>Beli <b x-text="qty"></b> pasang sekaligus</span>
                        </template>
                        <template x-if="qty === 1">
                            <span>Jumlah pembelian</span>
                        </template>
                    </span>
                </div>

                {{-- Action Buttons --}}
                <div class="pd-actions">
                    <form action="{{ route('buy-now') }}" method="POST"
                        @submit.prevent="
                            if(!isLoggedIn){
                                window.location.href='{{ route('customer.login') }}';
                                return;
                            }
                            if(!selectedSize){
                                triggerError('Pilih ukuran sepatu terlebih dahulu sebelum membeli');
                                return;
                            }
                            $el.submit()
                        ">
                        @csrf <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <input type="hidden" name="size" :value="selectedSize">

                        <input type="hidden" name="qty" x-model="qty">

                        <button type="submit" class="pd-btn pd-btn-checkout">

                            Beli Sekarang

                        </button>

                    </form>
                    <form action="{{ route('cart.store') }}" method="POST"
                        @submit.prevent="
                            if(!isLoggedIn){
                                window.location.href='{{ route('customer.login') }}';
                                return;
                            }
                            if(!selectedSize){
                                triggerError('Silakan pilih ukuran sepatu terlebih dahulu');
                                return;
                            }
                            $el.submit()
                        ">

                        @csrf

                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <input type="hidden" name="size" :value="selectedSize">

                        <input type="hidden" name="qty" :value="qty">

                        <button type="submit" class="pd-btn pd-btn-cart" 
                            :class="{
                                'opacity-60': !selectedSize
                            }">
                            @if ($errors->any())
                                <div class="mt-3 text-red-500 text-sm">

                                    {{ $errors->first() }}

                                </div>
                            @endif

                            Keranjang

                        </button>

                    </form>
                     <button class="pd-btn pd-btn-wishlist" :class="{ 'wishlisted': wishlisted }"
                        @click="if(!isLoggedIn){ window.location.href='{{ route('customer.login') }}'; return; } wishlisted = !wishlisted; toggleWishlist({{ $product->id }}, wishlisted);">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                            :fill="wishlisted ? '#e63' : 'none'" :stroke="wishlisted ? '#e63' : 'currentColor'" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2 9.5a5.5 5.5 0 019.591-3.676.56.56 0 00.818 0A5.49 5.49 0 0122 9.5c0 2.29-1.5 4-3 5.5l-5.492 5.313a2 2 0 01-3 .019L5 15c-1.5-1.5-3-3.2-3-5.5" />
                        </svg>
                    </button>
                </div>

                {{-- Chat to Store --}}
                <button class="pd-btn-chat">
                    {{-- <button class="pd-btn-chat" @click="window.open('{{ route('chat.store', $product->store_id ?? 1) }}', '_blank')"> --}}
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2V8z" />
                    </svg>
                    Chat ke Toko
                </button>

                <hr class="pd-divider">

                {{-- Description --}}
                <div class=" mt-10 rounded-3xl border border-[#e5e5e3] bg-white p-6">

                    <h3 class="  mb-4  text-lg  font-semibold">

                        Deskripsi Produk

                    </h3>

                    <div class="  max-h-[350px]  overflow-y-auto  pr-3  text-sm  leading-7  text-zinc-600">

                        {!! nl2br(e($product->description)) !!}

                    </div>

                </div>

            </div>
        </div>
        {{-- /MAIN --}}

        {{-- ── ZOOM MODAL ── --}}
        <div class="pd-zoom-modal" x-show="zoomOpen" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0"
            @click.self="zoomOpen = false">
            <button class="pd-zoom-close" @click="zoomOpen = false">✕</button>
            <img :src="activeImgUrl" alt="">
        </div>

        {{-- ════ WRITE REVIEW FORM ════ --}}
        <div class="pd-reviews-section" style="background:#f8f8f8;border-radius:16px;padding:clamp(20px,4vw,32px);margin-bottom:clamp(32px,6vw,48px);">
            
            <p class="pd-section-title" style="margin-bottom:16px;">Tulis Ulasan Anda</p>

            @if (session('customer_id'))
                @php
                    $existingReview = \App\Models\Testimonial::where('customer_id', session('customer_id'))
                        ->where('product_id', $product->id)
                        ->first();
                @endphp

                @if ($existingReview)
                    <div style="background:#fff3cd;border-left:4px solid #ffc107;padding:12px;border-radius:6px;margin-bottom:20px;font-size:13px;color:#856404;">
                        ✓ Anda sudah menulis ulasan untuk produk ini
                    </div>
                @else
                    <form action="{{ route('testimonials.store') }}" method="POST" style="display:flex;flex-direction:column;gap:16px;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        {{-- Rating --}}
                        <div>
                            <label style="display:block;font-size:12px;font-weight:600;margin-bottom:8px;color:#000039;">Rating</label>
                            <div style="display:flex;gap:8px;align-items:center;">
                                <input type="hidden" id="rating-input" name="rating" value="5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="pd-star" style="font-size:24px;cursor:pointer;transition:transform 200ms;" 
                                        @click="document.getElementById('rating-input').value = {{ $i }}; document.querySelectorAll('.rating-star').forEach((el, idx) => { el.style.opacity = idx < {{ $i }} ? '1' : '0.3'; });"
                                        :class="{}"
                                        class="rating-star"
                                        style="opacity:1;transform:scale(1.1);">★</span>
                                @endfor
                            </div>
                            @error('rating') <span style="color:#dc2626;font-size:12px;">{{ $message }}</span> @enderror
                        </div>

                        {{-- Comment --}}
                        <div>
                            <label style="display:block;font-size:12px;font-weight:600;margin-bottom:8px;color:#000039;">Ulasan (minimal 10 karakter)</label>
                            <textarea name="comment" 
                                placeholder="Bagikan pengalaman Anda dengan produk ini..."
                                style="width:100%;padding:12px;border:1px solid #e0e0e0;border-radius:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;resize:vertical;min-height:100px;outline:none;"
                                required minlength="10" maxlength="1000"></textarea>
                            <div style="font-size:11px;color:#666;margin-top:4px;">Maksimal 1000 karakter</div>
                            @error('comment') <span style="color:#dc2626;font-size:12px;">{{ $message }}</span> @enderror
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" style="background:#000039;color:white;padding:10px 20px;border:none;border-radius:8px;font-weight:600;font-size:13px;cursor:pointer;transition:background 200ms;align-self:flex-start;"
                            @mouseover="this.style.background='rgba(0,0,57,0.85)'"
                            @mouseout="this.style.background='#000039'">
                            Kirim Ulasan
                        </button>
                    </form>
                @endif
            @else
                <div style="background:#e3f2fd;border-left:4px solid #2196f3;padding:12px;border-radius:6px;font-size:13px;color:#1565c0;">
                    <p style="margin:0;margin-bottom:8px;">Anda harus login untuk menulis ulasan</p>
                    <a href="{{ route('login') }}" style="color:#1565c0;text-decoration:underline;font-weight:600;">Login di sini</a>
                </div>
            @endif
        </div>

        {{-- ════ REVIEWS ════ --}}
        <div class="pd-reviews-section">

            <div style="height:1.5px;background:rgba(0,0,57,.08);margin-bottom:clamp(24px,4vw,40px);"></div>
            <p class="pd-section-title">Ulasan Pembeli</p>

            {{-- Summary --}}
            <div class="pd-review-summary">
                <div style="text-align:center;">
                    <div class="pd-avg-score">{{ number_format($product->reviews?->avg('rating') ?? 4.5, 1) }}</div>
                    <div class="pd-stars" style="justify-content:center;margin:6px 0 4px;">
                        @for ($i = 1; $i <= 5; $i++)
                            <span
                                class="{{ $i <= round($product->reviews?->avg('rating') ?? 4.5) ? 'pd-star' : 'pd-star-empty' }}">★</span>
                        @endfor
                    </div>
                    <div class="pd-avg-label">dari {{ $product->reviews?->count() ?? 0 }} ulasan</div>
                </div>
                <div style="flex:1;">
                    @foreach ([5, 4, 3, 2, 1] as $star)
                        @php
                            $cnt =
                                $product->reviews?->where('rating', $star)->count() ??
                                [5 => 12, 4 => 5, 3 => 2, 2 => 1, 1 => 0][$star];
                            $total = max(1, $product->reviews?->count() ?? 20);
                        @endphp
                        <div class="pd-bar-row">
                            <span class="pd-bar-label">{{ $star }}</span>
                            <span style="color:#f5a623;font-size:11px;">★</span>
                            <div class="pd-bar-track">
                                <div class="pd-bar-fill" style="width:{{ round(($cnt / $total) * 100) }}%"></div>
                            </div>
                            <span class="pd-bar-count">{{ $cnt }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Filter Chips --}}
            <div class="pd-review-filters" x-data="{ filter: 'Semua' }">
                @foreach (['Semua', '5 ★', '4 ★', '3 ★', '2 ★', '1 ★'] as $chip)
                    <button class="pd-filter-chip" :class="{ active: filter === '{{ $chip }}' }"
                        @click="filter = '{{ $chip }}'">{{ $chip }}</button>
                @endforeach

                {{-- Review Cards --}}
                <div class="pd-review-list" style="width:100%;margin-top:16px;">
                    @forelse($product->reviews ?? [] as $review)
                        <div class="pd-review-card">
                            <div class="pd-review-header">
                                <div style="display:flex;align-items:flex-start;gap:10px;">
                                    <div class="pd-reviewer-avatar">
                                        {{ strtoupper(substr($review->customer?->name ?? $review->user?->name ?? 'Anonim', 0, 1)) }}</div>
                                    <div>
                                        <div class="pd-reviewer-name">{{ $review->customer?->name ?? $review->user?->name ?? 'Anonim' }}</div>
                                        <div class="pd-review-date">{{ $review->created_at?->format('d M Y') }}</div>
                                    </div>
                                </div>
                                <div>
                                    <div class="pd-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span
                                                class="{{ $i <= $review->rating ? 'pd-star' : 'pd-star-empty' }}">★</span>
                                        @endfor
                                    </div>
                                    @if ($review->verified_purchase ?? false)
                                        <span class="pd-verified" style="display:block;text-align:right;margin-top:3px;">✓
                                            Terverifikasi</span>
                                    @endif
                                </div>
                            </div>
                            <p class="pd-review-text">{{ $review->comment }}</p>
                            @if ($review->size_purchased ?? null)
                                <span class="pd-review-tag">Ukuran: {{ $review->size_purchased }}</span>
                            @endif
                        </div>
                    @empty
                        {{-- Placeholder reviews untuk demo --}}
                        @foreach ([['A', 'Andi Pratama', 5, '2025-03-10', 'Sepatu sangat nyaman dipakai seharian, bahan ringan dan sol empuk. Cocok banget buat anak yang aktif. Pengiriman juga cepat!', '40', 'true'], ['S', 'Sari Dewi', 4, '2025-02-28', 'Kualitas bagus, tapi warnanya sedikit berbeda dari foto. Overall masih puas dan recommended!', '38', 'true'], ['B', 'Budi Santoso', 5, '2025-02-15', 'Sudah beli ke-3 kalinya. Kualitas konsisten, pengiriman cepat. Recommended banget!', '42', 'false'], ['R', 'Rina Agustina', 3, '2025-01-20', 'Sepatu oke, tapi jahitan di bagian kanan kurang rapi. Tapi toko responsif dan mau replace.', '37', 'true']] as [$init, $name, $rat, $date, $comment, $sz, $ver])
                            <div class="pd-review-card">
                                <div class="pd-review-header">
                                    <div style="display:flex;align-items:flex-start;gap:10px;">
                                        <div class="pd-reviewer-avatar"
                                            style="background:{{ ['#2563eb', '#7c3aed', '#059669', '#d97706'][$loop->index % 4] }}">
                                            {{ $init }}</div>
                                        <div>
                                            <div class="pd-reviewer-name">{{ $name }}</div>
                                            <div class="pd-review-date">
                                                {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="pd-stars">
                                            @for ($i = 1; $i <= $rat; $i++)
                                                <span class="pd-star">★</span>
                                            @endfor
                                            @for ($i = $rat + 1; $i <= 5; $i++)
                                                <span class="pd-star-empty">★</span>
                                            @endfor
                                        </div>
                                        @if ($ver === 'true')
                                            <span class="pd-verified"
                                                style="display:block;text-align:right;margin-top:3px;">✓
                                                Terverifikasi</span>
                                        @endif
                                    </div>
                                </div>
                                <p class="pd-review-text">{{ $comment }}</p>
                                <span class="pd-review-tag">Ukuran: {{ $sz }}</span>
                            </div>
                        @endforeach
                    @endforelse
                </div>
            </div>

        </div>

        {{-- ════ RECOMMENDATIONS ════ --}}
        <div class="pd-reco-section">
            <div style="height:1.5px;background:rgba(0,0,57,.08);margin-bottom:clamp(24px,4vw,40px);"></div>
            <p class="pd-section-title">Produk Rekomendasi</p>
            <div class="pd-reco-grid">
                @foreach ($recommendations ?? [] as $rec)
                    <a href="{{ route('product.show', $rec) }}" class="pd-reco-card">
                        <div class="pd-reco-img">
                            @if($rec->images->first())
                                <img src="{{ asset('storage/' . $rec->images->first()->image) }}"
                                    alt="{{ $rec->name }}" loading="lazy">
                            @else
                                <div class="flex items-center justify-center w-full h-full text-[10px] font-bold uppercase tracking-widest text-[#aaa]">
                                    No Image
                                </div>
                            @endif
                        </div>
                        <div class="pd-reco-body">
                            <div class="pd-reco-cat">{{ $rec->categories->first()?->name }}</div>
                            <div class="pd-reco-name">{{ $rec->name }}</div>
                            <div class="pd-reco-price">Rp{{ number_format($rec->price, 0, ',', '.') }}</div>
                        </div>
                    </a>
                @endforeach

                {{-- Fallback placeholder jika $recommendations kosong --}}
                @if (empty($recommendations) || count($recommendations) === 0)
                    @foreach (range(1, 4) as $i)
                        <div class="pd-reco-card">
                            <div class="pd-reco-img" style="background:#ebebea;"></div>
                            <div class="pd-reco-body">
                                <div class="pd-reco-cat">Sneakers</div>
                                <div class="pd-reco-name">Produk Rekomendasi {{ $i }}</div>
                                <div class="pd-reco-price">Rp149.000</div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>{{-- /pd-wrap --}}

    <script>
        function addToCart(id) {
            const qty = document.querySelector('[x-data]')?._x_dataStack?.[0]?.qty ?? 1;
            console.log('Cart:', id, 'qty:', qty);
            // POST ke route cart
        }

        function addToWishlist(id) {
            console.log('Wishlist toggle:', id);
        }
    </script>

@endsection
