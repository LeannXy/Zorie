<section class="py-12 bg-white min-h-screen" x-data="{ 
    selectedItems: [],
    allSelected: false,
    cartItemsCount: {{ $cartItems->count() }},
    cartData: @js($cartItems->map(fn($item) => [
        'id' => $item->id,
        'subtotal' => $item->product->price * $item->qty
    ])),
    
    toggleAll() {
        this.selectedItems = this.allSelected ? {{ json_encode($cartItems->pluck('id')->toArray()) }} : [];
    },
    
    updateAllSelected() {
        this.allSelected = this.selectedItems.length === this.cartItemsCount && this.cartItemsCount > 0;
    },

    get selectedTotal() {
        return this.cartData
            .filter(item => this.selectedItems.includes(item.id))
            .reduce((sum, item) => sum + item.subtotal, 0);
    },

    formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number).replace('Rp', 'Rp ');
    }
}">
    <div class="max-w-[1280px] mx-auto px-5">
        {{-- PAGE HEADER --}}
        <div class="mb-10 flex items-end justify-between">
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight">Keranjang Belanja</h1>
                <p class="text-gray-500 mt-2">Kelola barang pilihanmu sebelum melakukan pembayaran.</p>
            </div>
            <div class="hidden sm:flex items-center gap-2 text-[11px] text-[#aaa] font-semibold tracking-[0.04em] mb-1">
                <a href="/" class="hover:text-[#111] transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="9 18 15 12 9 6" />
                </svg>
                <span class="text-[#111]">Keranjang</span>
            </div>
        </div>
 
        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                {{-- DAFTAR ITEM --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center justify-between p-5 bg-[#f5f5f3] border border-[#e5e5e3] rounded-2xl">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="allSelected" @change="toggleAll" 
                                class="w-5 h-5 border-gray-300 rounded text-black focus:ring-black transition-all">
                            <span class="text-sm font-bold text-gray-900 group-hover:text-black">Pilih Semua ({{ $cartItems->count() }})</span>
                        </label>
                        <button @click="selectedItems = []; allSelected = false" x-show="selectedItems.length > 0" 
                            class="text-xs font-bold text-red-600 hover:underline">Hapus Pilihan</button>
                    </div>

                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-5 p-5 border border-[#e5e5e3] rounded-3xl bg-white hover:border-gray-300 transition-all group">
                                <div class="flex items-center h-full">
                                    <input type="checkbox" value="{{ $item->id }}" x-model="selectedItems" @change="updateAllSelected"
                                        class="w-5 h-5 border-gray-300 rounded text-black focus:ring-black transition-all">
                                </div>

                                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-shrink-0 overflow-hidden rounded-2xl border border-[#e5e5e3] bg-[#f5f5f3]">
                                    @if($item->product->images->count() > 0)
                                        <img src="{{ asset('storage/' . $item->product->images->first()->image) }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gray-50 flex items-center justify-center text-[10px] text-gray-400">No Image</div>
                                    @endif
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-[14px] font-bold text-[#111] truncate">{{ $item->product->name }}</h3>
                                    <p class="text-[12px] text-[#aaa] mt-1">Size: <span class="font-bold text-[#111]">{{ $item->size }}</span></p>
                                    <p class="text-[16px] font-black text-[#111] mt-2">Rp {{ number_format($item->product->price * $item->qty, 0, ',', '.') }}</p>
                                </div>

                                <div class="flex flex-col items-end gap-4">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[#ccc] hover:text-red-500 transition-colors">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                    
                                    <div class="flex items-center bg-[#f5f5f3] rounded-xl p-1 border border-[#e5e5e3]">
                                        <form action="{{ route('cart.update', $item) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="qty" value="{{ max(1, $item->qty - 1) }}">
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center font-bold text-[#555] hover:text-[#111] transition-colors">−</button>
                                        </form>
                                        <span class="w-8 text-center text-[13px] font-bold text-[#111]">{{ $item->qty }}</span>
                                        <form action="{{ route('cart.update', $item) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="qty" value="{{ $item->qty + 1 }}">
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center font-bold text-[#555] hover:text-[#111] transition-colors">+</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- RINGKASAN --}}
                <div class="lg:col-span-1 space-y-4">
                    <div class="bg-white p-6 rounded-3xl border border-[#e5e5e3] sticky top-32">
                        <p class="text-[10.5px] font-bold tracking-[0.12em] uppercase text-[#aaa] mb-6">Ringkasan Pesanan</p>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-[13px] text-[#666]">
                                <span>Produk Dipilih</span>
                                <span class="font-bold text-[#111]" x-text="selectedItems.length">0</span>
                            </div>
                            <div class="border-t border-[#f0f0ee] pt-4 flex justify-between items-center">
                                <span class="text-[14px] font-black text-[#111]">Total Belanja</span>
                                <span class="text-[20px] font-black text-[#111]" x-text="formatRupiah(selectedTotal)"></span>
                            </div>
                        </div>

                        <form action="{{ route('checkout') }}" method="GET">
                            <template x-for="id in selectedItems" :key="id">
                                <input type="hidden" name="selected_items[]" :value="id">
                            </template>
                            
                            <button type="submit" :disabled="selectedItems.length === 0"
                                :class="selectedItems.length === 0 ? 'bg-[#f0f0ee] text-[#ccc] cursor-not-allowed' : 'bg-[#111] text-white hover:bg-[#222]'"
                                class="w-full py-4 rounded-2xl text-[11px] font-bold tracking-[0.14em] uppercase transition-all duration-300">
                                Lanjut ke Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="py-24 text-center bg-white rounded-[40px] border-2 border-dashed border-[#e5e5e3]">
                <div class="max-w-xs mx-auto">
                    <svg class="w-20 h-20 mx-auto text-[#eee] mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="1.5"/>
                    </svg>
                    <p class="text-[#aaa] font-bold text-lg leading-tight">Wah, keranjangmu masih kosong nih.</p>
                    <a href="{{ route('home') }}" class="mt-6 inline-block bg-[#111] text-white px-10 py-3 rounded-2xl font-bold hover:bg-[#222] transition-all">Mulai Belanja</a>
                </div>
            </div>
        @endif
    </div>
</section>
