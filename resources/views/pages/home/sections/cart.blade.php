{{--
    ZORIE — Cart Page
    Stack : Tailwind CSS + Alpine.js + Laravel Blade
    Font  : Plus Jakarta Sans (load in your layout)
--}}

<div
  class="min-h-screen bg-[#f5f5f3] font-['Plus_Jakarta_Sans',sans-serif]"
  x-data="{
    items: [
      { id: 1, name: 'Exotek NITRO Running Shoes', variant: 'Hitam / Size 42', price: 1299000, qty: 1, stock: 5, checked: true },
      { id: 2, name: 'Zorie Casual Slip-On',        variant: 'Putih / Size 40', price: 799000,  qty: 2, stock: 3, checked: true },
      { id: 3, name: 'Classic Canvas Low',           variant: 'Navy / Size 41',  price: 599000,  qty: 1, stock: 8, checked: false },
    ],
    coupon: '',
    couponApplied: false,
    couponDiscount: 0,
    removeModal: false,
    removeId: null,
    removeName: '',

    get checkedItems() { return this.items.filter(i => i.checked); },
    get subtotal()     { return this.checkedItems.reduce((s,i) => s + i.price * i.qty, 0); },
    get shipping()     { return this.checkedItems.length > 0 ? 25000 : 0; },
    get discount()     { return this.couponApplied ? this.couponDiscount : 0; },
    get total()        { return Math.max(0, this.subtotal + this.shipping - this.discount); },
    get allChecked()   { return this.items.length > 0 && this.items.every(i => i.checked); },

    fmt(n) { return 'Rp ' + n.toLocaleString('id-ID'); },

    toggleAll(v)   { this.items.forEach(i => i.checked = v); },
    inc(item)      { if (item.qty < item.stock) item.qty++; },
    dec(item)      { if (item.qty > 1) item.qty--; },
    confirmRemove(item) { this.removeId = item.id; this.removeName = item.name; this.removeModal = true; },
    doRemove()     { this.items = this.items.filter(i => i.id !== this.removeId); this.removeModal = false; },
    removeChecked(){ this.items = this.items.filter(i => !i.checked); },

    applyCoupon() {
      if (this.coupon.trim().toUpperCase() === 'ZORIE10') {
        this.couponDiscount = Math.round(this.subtotal * 0.10);
        this.couponApplied = true;
      } else {
        this.couponApplied = false;
        this.couponDiscount = 0;
      }
    },
  }"
>

  {{-- ─────────────────────────────────────────────────────
       PAGE HEADER
  ───────────────────────────────────────────────────── --}}
  <div class="border-b border-[#e5e5e3] bg-white">
    <div class="max-w-[1280px] mx-auto px-5 py-5 flex items-center justify-between">

      <div>
        <h1 class="text-[22px] font-black tracking-[-0.04em] text-[#111]">Keranjang Belanja</h1>
        <p class="text-[12.5px] text-[#aaa] mt-0.5">
          <span x-text="items.length"></span> produk tersimpan
        </p>
      </div>

      {{-- Breadcrumb --}}
      <div class="hidden sm:flex items-center gap-2 text-[11px] text-[#aaa] font-semibold tracking-[0.04em]">
        <a href="/" class="hover:text-[#111] transition-colors">Beranda</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span class="text-[#111]">Keranjang</span>
      </div>

    </div>
  </div>

  {{-- ─────────────────────────────────────────────────────
       CHECKOUT STEPS INDICATOR
  ───────────────────────────────────────────────────── --}}
  <div class="bg-white border-b border-[#e5e5e3]">
    <div class="max-w-[1280px] mx-auto px-5 py-4">
      <div class="flex items-center gap-0 max-w-md">

        @foreach([
          ['1','Keranjang', true],
          ['2','Pengiriman', false],
          ['3','Pembayaran', false],
        ] as [$n, $lbl, $active])
        <div class="flex items-center">
          <div class="flex items-center gap-2">
            <div class="{{ $active ? 'bg-[#111] text-white' : 'bg-[#f0f0ee] text-[#bbb]' }} w-7 h-7 rounded-full text-[11px] font-black flex items-center justify-center flex-shrink-0">{{ $n }}</div>
            <span class="text-[11.5px] font-bold {{ $active ? 'text-[#111]' : 'text-[#bbb]' }} hidden sm:block">{{ $lbl }}</span>
          </div>
          @if(!$loop->last)
          <div class="w-8 sm:w-14 h-px bg-[#e5e5e3] mx-2 sm:mx-3"></div>
          @endif
        </div>
        @endforeach

      </div>
    </div>
  </div>

  {{-- ─────────────────────────────────────────────────────
       MAIN CONTENT
  ───────────────────────────────────────────────────── --}}
  <div class="max-w-[1280px] mx-auto px-5 py-8 flex flex-col lg:flex-row gap-6 items-start">

    {{-- ══════════════════════════════════
         LEFT — CART ITEMS
    ══════════════════════════════════ --}}
    <div class="flex-1 min-w-0 space-y-4">

      {{-- Toolbar --}}
      <div class="bg-white rounded-2xl border border-[#e5e5e3] px-5 py-3.5 flex items-center justify-between gap-3">

        <label class="flex items-center gap-2.5 cursor-pointer select-none">
          <div class="relative flex items-center">
            <input
              type="checkbox"
              :checked="allChecked"
              @change="toggleAll($event.target.checked)"
              class="w-4.5 h-4.5 rounded border-[#ccc] accent-[#111] cursor-pointer"
            >
          </div>
          <span class="text-[12.5px] font-bold text-[#111]">
            Pilih Semua (<span x-text="items.length"></span>)
          </span>
        </label>

        <button
          x-show="checkedItems.length > 0"
          @click="removeChecked()"
          class="flex items-center gap-1.5 text-[11.5px] font-bold text-red-500 hover:text-red-600 transition-colors"
          x-transition
        >
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
          Hapus Dipilih (<span x-text="checkedItems.length"></span>)
        </button>

      </div>

      {{-- Empty state --}}
      <div
        x-show="items.length === 0"
        x-transition
        class="bg-white rounded-2xl border border-[#e5e5e3] py-20 text-center"
        style="display:none;"
      >
        <div class="w-16 h-16 rounded-2xl bg-[#f5f5f3] flex items-center justify-center mx-auto mb-5">
          <svg class="w-8 h-8 text-[#ccc]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <p class="text-[15px] font-black tracking-[-0.02em] text-[#111]">Keranjang masih kosong</p>
        <p class="text-[12.5px] text-[#aaa] mt-1.5 mb-6">Yuk tambahkan produk favoritmu ke sini.</p>
        <a href="/products" class="inline-flex items-center gap-2 px-6 py-3 bg-[#111] text-white rounded-xl text-[12px] font-bold hover:bg-[#222] transition-all">
          Mulai Belanja
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </div>

      {{-- Item list --}}
      <template x-for="item in items" :key="item.id">
        <div
          class="bg-white rounded-2xl border border-[#e5e5e3] p-5 transition-all"
          :class="item.checked ? 'border-[#e5e5e3]' : 'opacity-60'"
        >
          <div class="flex items-start gap-4">

            {{-- Checkbox --}}
            <div class="pt-1 flex-shrink-0">
              <input
                type="checkbox"
                x-model="item.checked"
                class="w-4 h-4 rounded border-[#ccc] accent-[#111] cursor-pointer"
              >
            </div>

            {{-- Product image placeholder --}}
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-[#f5f5f3] border border-[#e5e5e3] flex items-center justify-center flex-shrink-0 relative overflow-hidden">
              <svg class="w-8 h-8 text-[#ccc]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
              {{-- Replace with: <img :src="item.image" class="w-full h-full object-cover"> --}}
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">

              <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                  <p class="text-[13.5px] font-bold text-[#111] leading-snug" x-text="item.name"></p>
                  <p class="text-[11.5px] text-[#aaa] mt-0.5" x-text="item.variant"></p>

                  {{-- Low stock warning --}}
                  <p
                    x-show="item.stock <= 3"
                    class="mt-1.5 text-[10.5px] font-bold text-orange-500 flex items-center gap-1"
                  >
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                    Sisa <span x-text="item.stock"></span> produk
                  </p>
                </div>

                {{-- Remove button --}}
                <button
                  @click="confirmRemove(item)"
                  class="flex-shrink-0 w-7 h-7 rounded-lg border border-[#f0f0ee] flex items-center justify-center text-[#ccc] hover:border-red-200 hover:text-red-400 hover:bg-red-50 transition-all"
                  title="Hapus"
                >
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
              </div>

              {{-- Price + qty --}}
              <div class="flex items-center justify-between mt-4 flex-wrap gap-3">

                {{-- Price --}}
                <div>
                  <p class="text-[16px] font-black tracking-[-0.03em] text-[#111]" x-text="fmt(item.price * item.qty)"></p>
                  <p class="text-[11px] text-[#aaa]" x-show="item.qty > 1">
                    <span x-text="fmt(item.price)"></span> / pcs
                  </p>
                </div>

                {{-- Qty stepper --}}
                <div class="flex items-center gap-0 border border-[#e5e5e3] rounded-xl overflow-hidden">
                  <button
                    @click="dec(item)"
                    :disabled="item.qty <= 1"
                    class="w-9 h-9 flex items-center justify-center text-[#555] hover:bg-[#f5f5f3] disabled:text-[#ccc] disabled:cursor-not-allowed transition-colors"
                  >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/></svg>
                  </button>
                  <div class="w-10 h-9 flex items-center justify-center border-x border-[#e5e5e3]">
                    <span class="text-[13px] font-bold text-[#111]" x-text="item.qty"></span>
                  </div>
                  <button
                    @click="inc(item)"
                    :disabled="item.qty >= item.stock"
                    class="w-9 h-9 flex items-center justify-center text-[#555] hover:bg-[#f5f5f3] disabled:text-[#ccc] disabled:cursor-not-allowed transition-colors"
                  >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                  </button>
                </div>

              </div>
            </div>
          </div>
        </div>
      </template>

      {{-- Continue shopping --}}
      <div x-show="items.length > 0" class="pt-1">
        <a href="/products" class="inline-flex items-center gap-2 text-[12px] font-bold text-[#555] hover:text-[#111] transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
          Lanjut Belanja
        </a>
      </div>

    </div>

    {{-- ══════════════════════════════════
         RIGHT — ORDER SUMMARY
    ══════════════════════════════════ --}}
    <div class="w-full lg:w-[340px] flex-shrink-0 space-y-4 lg:sticky lg:top-8">

      {{-- Coupon --}}
      <div class="bg-white rounded-2xl border border-[#e5e5e3] px-5 py-5">
        <p class="text-[10.5px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-3">Kode Promo</p>
        <div class="flex gap-2">
          <input
            type="text"
            x-model="coupon"
            @keydown.enter="applyCoupon()"
            placeholder="Masukkan kode promo"
            :class="couponApplied ? 'border-green-400 bg-green-50' : 'border-[#ebebea] bg-[#f8f8f6]'"
            class="flex-1 px-4 py-2.5 border rounded-xl text-[12.5px] text-[#111] outline-none focus:border-[#111] transition-all placeholder:text-[#ccc] uppercase tracking-[0.06em]"
          >
          <button
            @click="applyCoupon()"
            class="px-4 py-2.5 bg-[#111] text-white rounded-xl text-[11px] font-bold hover:bg-[#222] transition-all flex-shrink-0"
          >Pakai</button>
        </div>
        <div x-show="couponApplied" x-transition class="mt-2.5 flex items-center gap-1.5 text-[11.5px] font-bold text-green-600" style="display:none;">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
          Kode <span class="uppercase" x-text="coupon.trim()"></span> berhasil! Hemat <span x-text="fmt(couponDiscount)"></span>
        </div>
        <div x-show="!couponApplied && coupon.length > 0" class="mt-2 text-[11px] text-red-400 font-semibold" style="display:none;">
          Kode promo tidak valid. Coba: ZORIE10
        </div>
      </div>

      {{-- Summary --}}
      <div class="bg-white rounded-2xl border border-[#e5e5e3] px-5 py-5">
        <p class="text-[10.5px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-4">Ringkasan Pesanan</p>

        <div class="space-y-3 text-[13px]">

          <div class="flex items-center justify-between">
            <span class="text-[#666]">
              Subtotal
              (<span x-text="checkedItems.length"></span> produk)
            </span>
            <span class="font-semibold text-[#111]" x-text="fmt(subtotal)"></span>
          </div>

          <div class="flex items-center justify-between">
            <span class="text-[#666]">Ongkos Kirim</span>
            <span class="font-semibold text-[#111]" x-text="shipping > 0 ? fmt(shipping) : 'Gratis'"></span>
          </div>

          <div x-show="couponApplied" x-transition class="flex items-center justify-between text-green-600" style="display:none;">
            <span class="font-semibold">Diskon Promo</span>
            <span class="font-bold">- <span x-text="fmt(discount)"></span></span>
          </div>

        </div>

        <div class="border-t border-[#f0f0ee] mt-4 pt-4 flex items-center justify-between">
          <span class="text-[13px] font-black tracking-[-0.01em] text-[#111]">Total</span>
          <span class="text-[20px] font-black tracking-[-0.04em] text-[#111]" x-text="fmt(total)"></span>
        </div>

        <p class="text-[10.5px] text-[#bbb] mt-1.5 text-right">Sudah termasuk PPN jika berlaku</p>

        {{-- Checkout CTA --}}
        <button
          :disabled="checkedItems.length === 0"
          class="mt-5 w-full py-4 bg-[#111] text-white rounded-xl text-[11px] font-bold tracking-[0.14em] uppercase
                 hover:bg-[#1a1a1a] hover:-translate-y-px hover:shadow-[0_8px_24px_rgba(0,0,0,0.16)]
                 active:translate-y-0 active:shadow-none
                 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:translate-y-0 disabled:hover:shadow-none
                 transition-all"
        >
          Lanjut ke Checkout
          <svg class="inline-block w-3.5 h-3.5 ml-1.5 -mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </button>

        <p class="text-[10.5px] text-[#ccc] text-center mt-3 flex items-center justify-center gap-1.5">
          <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
          Transaksi aman & terenkripsi
        </p>

      </div>

      {{-- Accepted payments --}}
      <div class="bg-white rounded-2xl border border-[#e5e5e3] px-5 py-4">
        <p class="text-[10px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-3">Metode Pembayaran</p>
        <div class="flex flex-wrap gap-2">
          @foreach(['Transfer Bank','QRIS','GoPay','OVO','Dana','COD'] as $method)
          <span class="px-3 py-1.5 bg-[#f5f5f3] border border-[#e5e5e3] rounded-lg text-[10.5px] font-semibold text-[#555]">{{ $method }}</span>
          @endforeach
        </div>
      </div>

      {{-- Free shipping info --}}
      <div class="bg-[#111] rounded-2xl px-5 py-4 flex items-center gap-3">
        <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
          <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12h12L19 8M10 12v4m4-4v4"/></svg>
        </div>
        <div>
          <p class="text-[12px] font-bold text-white">Gratis Ongkir</p>
          <p class="text-[11px] text-white/50 mt-0.5">untuk pembelian di atas Rp 500.000</p>
        </div>
      </div>

    </div>
  </div>

  {{-- ─────────────────────────────────────────────────────
       REMOVE CONFIRM MODAL
  ───────────────────────────────────────────────────── --}}
  <div
    x-show="removeModal"
    x-transition:enter="transition ease-out duration-150"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-5"
    style="display:none;"
  >
    <div
      @click.away="removeModal=false"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100"
      class="bg-white rounded-2xl border border-[#e5e5e3] p-7 w-full max-w-sm shadow-2xl"
    >
      <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center mb-4">
        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
      </div>
      <h3 class="text-[17px] font-black tracking-[-0.03em] text-[#111] mb-1.5">Hapus produk?</h3>
      <p class="text-[12.5px] text-[#aaa] leading-relaxed mb-5">
        <strong class="text-[#555]" x-text="removeName"></strong> akan dihapus dari keranjang belanja.
      </p>
      <div class="flex gap-3">
        <button @click="removeModal=false" class="flex-1 py-3 border border-[#e5e5e3] rounded-xl text-[12px] font-bold text-[#555] hover:bg-[#f5f5f3] transition-all">Batal</button>
        <button @click="doRemove()" class="flex-1 py-3 bg-red-500 text-white rounded-xl text-[12px] font-bold hover:bg-red-600 transition-all">Hapus</button>
      </div>
    </div>
  </div>

</div>