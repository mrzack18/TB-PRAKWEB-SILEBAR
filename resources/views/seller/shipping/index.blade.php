@extends('layouts.dashboard')

@section('title', 'Pengiriman - SILEBAR')
@section('header-title', 'Pengiriman Barang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Barang Menunggu Pengiriman</h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Barang
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pembeli
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Harga Final
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($transactions as $transaction)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $transaction->auctionItem->title }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $transaction->winner->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-blue-600">Rp {{ number_format($transaction->final_price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($transaction->shipping_status === 'waiting_shipment')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Menunggu Pengiriman
                                </span>
                            @elseif($transaction->shipping_status === 'processing')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Siap Dikirim
                                </span>
                            @elseif($transaction->shipping_status === 'shipped')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                    Dikirim
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if(in_array($transaction->shipping_status, ['waiting_shipment', 'processing']))
                                <button onclick="openShippingModal({{ $transaction->id }})" class="text-indigo-600 hover:text-indigo-900">Input Resi</button>
                            @else
                                <span class="text-sm text-gray-500">{{ $transaction->shipping_receipt ?? '-' }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($transactions->count() === 0)
        <div class="text-center py-8">
            <p class="text-gray-500">Tidak ada barang menunggu pengiriman</p>
        </div>
        @endif
    </div>
</div>

<!-- Shipping Modal -->
<div id="shipping-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Input Nomor Resi</h3>
                <button onclick="closeShippingModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="shipping-form" method="POST">
                @csrf
                @method('PATCH')
                <div class="mt-4">
                    <label for="shipping_receipt" class="block text-sm font-medium text-gray-700">Nomor Resi</label>
                    <input type="text" id="shipping_receipt" name="shipping_receipt" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeShippingModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan Resi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openShippingModal(transactionId) {
        document.getElementById('shipping-form').action = '/seller/shipping/' + transactionId + '/update';
        document.getElementById('shipping-modal').classList.remove('hidden');
    }
    
    function closeShippingModal() {
        document.getElementById('shipping-modal').classList.add('hidden');
    }
</script>
@endsection