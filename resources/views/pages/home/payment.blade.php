@extends('layouts.app')

@section('content')
    @include('pages.home.sections.navbar')

    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-xl text-center">
            <div class="animate-bounce mb-4">
                <svg class="w-16 h-16 mx-auto text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h2 class="text-2xl font-black text-gray-900">Menunggu Pembayaran</h2>
            <p class="text-sm text-gray-500">Silakan selesaikan pembayaran Anda melalui jendela yang muncul.</p>
            <button id="pay-button" class="mt-6 w-full py-4 bg-black text-white rounded-xl font-bold tracking-widest hover:bg-gray-800 transition-all">
                BAYAR SEKARANG
            </button>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        const payButton = document.getElementById('pay-button');
        
        function triggerSnap() {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) { window.location.href = "{{ route('checkout.success', $order->id) }}"; },
                onPending: function(result) { window.location.href = "{{ route('checkout.success', $order->id) }}"; },
                onError: function(result) { alert("Pembayaran gagal!"); },
                onClose: function() { alert('Anda menutup jendela pembayaran.'); }
            });
        }

        payButton.onclick = function() { triggerSnap(); };
        window.onload = function() { triggerSnap(); };
    </script>
@endsection