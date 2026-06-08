@extends('layouts.app')

@section('content')

    @include('pages.home.sections.navbar')

    <div class="min-h-screen bg-white pt-32 pb-16">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Success Card -->
            <div class="text-center">

                @if(request('from') !== 'history')
                <!-- Animated Checkmark -->
                <div class="flex justify-center mb-8">
                    <div class="relative w-24 h-24">
                        <svg class="w-24 h-24 success-circle" viewBox="0 0 96 96" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="48" cy="48" r="46" stroke="#111827" stroke-width="3"
                                stroke-dasharray="289" stroke-dashoffset="289"
                                style="animation: drawCircle 0.6s ease forwards;" />
                            <path d="M28 48L42 62L68 36" stroke="#111827" stroke-width="3.5"
                                stroke-linecap="round" stroke-linejoin="round"
                                stroke-dasharray="60" stroke-dashoffset="60"
                                style="animation: drawCheck 0.4s ease 0.5s forwards;" />
                        </svg>
                    </div>
                </div>
                @endif

                <!-- Heading -->
                <div style="animation: fadeUp 0.5s ease 0.8s both;">
                    <h1 class="text-3xl font-bold text-gray-900 mb-3">
                        {{ request('from') === 'history' ? 'Detail Transaksi' : 'Pesanan Berhasil Dibuat!' }}
                    </h1>
                    <p class="text-gray-500 text-sm mb-2">
                        Nomor Pesanan:
                        <span class="font-semibold text-gray-900">#{{ $order->order_number ?? 'ORD-' . str_pad($order->id ?? rand(1000, 9999), 6, '0', STR_PAD_LEFT) }}</span>
                    </p>
                    @if(request('from') !== 'history')
                    <p class="text-gray-500 text-sm">
                        Konfirmasi telah dikirim ke
                        <span class="font-semibold text-gray-900">{{ $customer->email }}</span>
                    </p>
                    @endif
                </div>

                <!-- Divider -->
                <div class="my-8 border-t border-gray-100" style="animation: fadeUp 0.5s ease 0.9s both;"></div>

                <!-- Order Summary -->
                <div class="bg-gray-50 rounded-2xl p-6 text-left mb-8" style="animation: fadeUp 0.5s ease 1s both;">
                    <h2 class="text-base font-bold text-gray-900 mb-4">Ringkasan Pesanan</h2>

                    <div class="space-y-4 mb-5">
                        @if(isset($order) && $order->items)
                            @foreach ($order->items as $item)
                                <div class="flex items-center gap-4">
                                    @if ($item->product->images->count() > 0)
                                        <img src="{{ asset('storage/' . $item->product->images->first()->image) }}"
                                            alt="{{ $item->product->name }}"
                                            class="w-14 h-14 object-cover rounded-lg border border-gray-200 flex-shrink-0">
                                    @else
                                        <div class="w-14 h-14 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-grow min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-900 flex-shrink-0">
                                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                    </p>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="border-t border-gray-200 pt-4 space-y-2 text-sm">
                        <div class="flex justify-between text-gray-500">
                            <span>Harga Produk</span>
                            <span>Rp {{ number_format(($order->total - $order->shipping_cost), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span>Pengiriman</span>
                            <span class="text-gray-900 font-semibold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-base font-bold text-gray-900 pt-2 border-t border-gray-200">
                            <span>Total Pembayaran</span>
                            <span>Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="bg-gray-50 rounded-2xl p-6 text-left mb-8" style="animation: fadeUp 0.5s ease 1.1s both;">
                    <h2 class="text-base font-bold text-gray-900 mb-4">Informasi Pengiriman</h2>
                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg> 
                            <span>{{ $order->address ?? '-' }}, {{ $order->city ?? '' }}, {{ $order->postal_code ?? '' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Estimasi tiba dalam <strong class="text-gray-900">5–6 hari kerja</strong></span>
                        </div>
                    </div>
                </div>

              <div class="mb-10" style="animation: fadeUp 0.5s ease 1.2s both;">
    <div class="flex items-start justify-between relative">
        
        @php
            $status = $order->status;
            // 1. Hitung persentase progres berdasarkan status pembeli
            $lineWidth = $status === 'Completed' ? '100%' : ($status === 'Shipped' ? '50%' : '0%');
            
            // 2. Tambahkan 'Pending' ke array agar tahap pertama langsung menyala saat pesanan sukses dibuat
            $steps = [
                [
                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 
                    'label' => "Pesanan\nDikonfirmasi", 
                    'active' => in_array($status, ['Pending', 'Paid', 'Processing', 'Shipped', 'Completed'])
                ],
                [
                    'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 
                    'label' => "Sedang\nDikirim", 
                    'active' => in_array($status, ['Shipped', 'Completed'])
                ],
                [
                    'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 
                    'label' => "Sampai\nTujuan", 
                    'active' => $status === 'Completed'
                ],
            ];
        @endphp

        <div class="absolute top-4 left-4 right-4 h-0.5 z-0">
            <div class="w-full h-full bg-gray-200 rounded"></div>
            <div class="absolute top-0 left-0 h-full bg-gray-900 transition-all duration-500 rounded" style="width: {{ $lineWidth }};"></div>
        </div>

        @foreach ($steps as $step)
            <div class="flex flex-col items-center gap-2 z-10 flex-1">
                <div class="w-8 h-8 rounded-full flex items-center justify-center transition-colors duration-500
                    {{ $step['active'] ? 'bg-gray-900' : 'bg-white border-2 border-gray-300' }}">
                    <svg class="w-4 h-4 {{ $step['active'] ? 'text-white' : 'text-gray-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="{{ $step['icon'] }}" />
                    </svg>
                </div>
                <p class="text-xs text-center text-gray-500 leading-tight whitespace-pre-line">{{ $step['label'] }}</p>
            </div>
        @endforeach
    </div>
</div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-3" style="animation: fadeUp 0.5s ease 1.3s both;">
                    <a href="{{ route('home') }}"
                        class="flex-1 border border-gray-300 hover:bg-gray-50 text-gray-900 py-3 rounded-xl font-semibold text-sm transition">
                        Lanjutkan Berbelanja
                    </a>
                    <a href="{{ route('orders.invoice', $order->id) }}"
                        class="flex-1 border border-gray-900 text-gray-900 py-3 rounded-xl font-semibold text-sm transition flex items-center justify-center gap-2 hover:bg-gray-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh Invoice
                    </a>
                    @if(isset($order))
                    <a href="{{ route('customer.orders') }}"
                        class="flex-1 bg-gray-900 hover:bg-gray-700 text-white py-3 rounded-xl font-semibold text-sm transition">
                        Kembali ke Pesanan
                    </a>
                    @endif
                </div>

            </div>
        </div>
    </div>

    @include('pages.home.sections.footer')

    <style>
        @keyframes drawCircle {
            to { stroke-dashoffset: 0; }
        }
        @keyframes drawCheck {
            to { stroke-dashoffset: 0; }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>

@endsection