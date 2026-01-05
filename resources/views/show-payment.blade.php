@extends('section.layout')

@section('content')
    <br>
    <br>
    <br>
    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-6">

        <h1 class="text-2xl font-bold text-[#5F1D2A] mb-4">
            Pembayaran
        </h1>

        {{-- Informasi Order --}}
        <div class="border rounded-lg p-4 mb-4 space-y-2">
            <p><strong>Penerima:</strong> {{ $order->receiver_name }}</p>
            <p><strong>No. Telepon:</strong> {{ $order->phone }}</p>
            <p><strong>Alamat:</strong> {{ $order->address }}</p>
            <p class="text-lg font-semibold text-right mt-4">
                Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </p>
        </div>

        {{-- Tombol Bayar --}}
        <button id="pay-button"
            class="w-full bg-[#5F1D2A] text-white py-3 rounded-lg font-bold
               hover:bg-[#4a1620] transition disabled:opacity-50 disabled:cursor-not-allowed"
            {{ !$order->snap_token ? 'disabled' : '' }}>
            Bayar Sekarang
        </button>

        {{-- Status --}}
        <p id="payment-status" class="mt-4 text-center text-sm text-gray-600"></p>

    </div>

@section('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        const snapToken = @json($order->snap_token);
        const orderId = {{ $order->id }};
        const csrfToken = '{{ csrf_token() }}';

        document.getElementById('pay-button').onclick = function() {
            if (!snapToken) {
                alert('Snap token belum tersedia');
                return;
            }

            snap.pay(snapToken, {

                onSuccess: function(result) {
                    fetch(`/payment/success/${orderId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(() => {
                            alert('Pembayaran berhasil!');
                            window.location.href = "/product";
                        });
                },

                onPending: function(result) {
                    alert('Pembayaran belum selesai.');
                },

                onError: function(result) {
                    cancelOrder();
                },
            });
        };

        function cancelOrder() {
            fetch(`/payment/cancel/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(() => {
                    alert('Pembayaran dibatalkan / kadaluarsa');
                    window.location.href = "/product";
                });
        }
    </script>


@endsection
