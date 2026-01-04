@extends('section.layout')

@section('content')
<div class="container mx-auto px-6 py-10">

    <h1 class="text-3xl font-bold text-[#5F1D2A] mb-6">
        📦 Dashboard Admin — Order Masuk
    </h1>

    <div class="bg-white rounded-xl shadow border border-[#B8A5A8]/30 overflow-x-auto">

        <table class="min-w-full text-sm">
            <thead class="bg-[#F8D9DF] text-[#5F1D2A]">
                <tr>
                    <th class="px-4 py-3 text-left">Order ID</th>
                    <th class="px-4 py-3 text-left">User</th>
                    <th class="px-4 py-3 text-left">Penerima</th>
                    <th class="px-4 py-3 text-left">Alamat</th>
                    <th class="px-4 py-3 text-left">Kurir</th>
                    <th class="px-4 py-3 text-right">Total</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Tanggal</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($orders as $order)
                    <tr class="border-t hover:bg-[#FFF8F6] transition">
                        <td class="px-4 py-3 font-semibold">#{{ $order->id }}</td>

                        <td class="px-4 py-3">
                            {{ $order->user->name ?? '-' }} <br>
                            <span class="text-xs text-gray-500">
                                {{ $order->user->email ?? '' }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            {{ $order->receiver_name }} <br>
                            <span class="text-xs text-gray-500">
                                {{ $order->phone }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-xs">
                            {{ $order->address }},
                            {{ $order->subdistrict }},
                            {{ $order->district }},
                            {{ $order->city }},
                            {{ $order->zip_code }}
                        </td>

                        <td class="px-4 py-3 uppercase">
                            {{ $order->courier }}
                        </td>

                        <td class="px-4 py-3 text-right font-bold">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            @php
                                $statusColor = match($order->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'paid' => 'bg-green-100 text-green-700',
                                    'shipped' => 'bg-blue-100 text-blue-700',
                                    'canceled' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            @endphp

                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-center text-xs">
                            {{ $order->created_at->format('d M Y') }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('orders.detail', $order) }}"
                                class="text-[#5F1D2A] font-semibold hover:underline">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-10 text-gray-400">
                            Belum ada order masuk
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>
@endsection
