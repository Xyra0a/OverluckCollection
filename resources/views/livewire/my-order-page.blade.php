<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-4xl font-bold text-slate-500">My Orders</h1>
    <div class="flex flex-col bg-white p-5 rounded mt-4 shadow-lg">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Order</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Product Name</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Order Status</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{ $order->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $order->created_at->format('d-m-Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                        @if ($order->items->isNotEmpty())
                                            <span class="py-1 px-3 font-semibold">
                                                {{ $order->items->pluck('product.name')->implode(', ') }}
                                            </span>
                                        @else
                                            <span class="bg-gray-500 py-1 px-3 rounded text-white shadow">N/A</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                        @if ($order->status == 'pending')
                                            <span class="w-28 h-8 bg-blue-50 border border-blue-300 flex items-center justify-center rounded-lg gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="18px" width="18px" version="1.1" id="Capa_1" viewBox="0 0 232.058 232.058" xml:space="preserve" class=" fill-current text-blue-400">
                                                    <g>
                                                        <path d="M16.45,103.92c5.972-33.874,29.885-61.607,61.536-73.034L76.5,33.461c-2.072,3.587-0.844,8.174,2.743,10.246   c1.182,0.682,2.471,1.007,3.744,1.007c2.591,0,5.112-1.345,6.501-3.75l10.34-17.901c0.995-1.723,1.266-3.77,0.751-5.691   c-0.515-1.922-1.771-3.56-3.494-4.555L79.179,2.476c-3.59-2.072-8.175-0.842-10.246,2.744c-2.071,3.587-0.843,8.174,2.744,10.245   l1.868,1.079C36.59,29.628,8.631,61.879,1.679,101.315c-3.364,19.06-1.651,38.703,4.953,56.807c1.11,3.043,3.984,4.931,7.047,4.931   c0.853,0,1.722-0.147,2.569-0.456c3.892-1.42,5.896-5.725,4.476-9.616C15.022,137.352,13.544,120.388,16.45,103.92z"/>
                                                    <path d="M193.646,180.699c-3.172-2.666-7.902-2.256-10.567,0.915c-21.818,25.955-56.084,38.429-89.437,32.542   c-16.189-2.855-31.295-9.876-43.866-20.192h2.413c4.143,0,7.5-3.358,7.5-7.5c0-4.142-3.357-7.5-7.5-7.5H32.222   c-1.927-0.182-3.923,0.376-5.523,1.718c-1.56,1.308-2.449,3.116-2.639,4.993c-0.001,0.007-0.002,0.013-0.003,0.02   c0,0.002,0,0.004,0,0.006c-0.021,0.215-0.031,0.431-0.033,0.647c-0.001,0.038-0.006,0.074-0.006,0.112l-0.008,20.67   c-0.002,4.142,3.355,7.501,7.497,7.503h0.003c4.141,0,7.498-3.356,7.5-7.497l0.001-2.612c14.795,12.509,32.75,21.004,52.026,24.403   c6.326,1.116,12.679,1.662,18.994,1.662c32.221,0,63.415-14.205,84.53-39.323C197.227,188.096,196.817,183.364,193.646,180.699z"/>
                                                    <path d="M231.052,142.479c-2.07-3.587-6.659-4.816-10.245-2.745l-2.467,1.424c0.102-0.53,0.222-1.057,0.315-1.588   c5.109-28.982-1.372-58.216-18.25-82.32c-16.878-24.104-42.132-40.191-71.109-45.296c-4.08-0.718-7.97,2.006-8.687,6.085   c-0.719,4.079,2.005,7.969,6.084,8.688c25.031,4.41,46.847,18.306,61.426,39.128c14.55,20.779,20.153,45.973,15.791,70.958   l-1.099-1.903c-2.071-3.587-6.658-4.818-10.245-2.747c-3.588,2.07-4.817,6.657-2.747,10.245l10.336,17.909   c0.995,1.723,2.633,2.98,4.555,3.495c0.639,0.171,1.291,0.256,1.941,0.256c1.305,0,2.6-0.341,3.75-1.005l17.906-10.338   C231.894,150.653,233.123,146.066,231.052,142.479z"/>
                                                </g>
                                                </svg>

                                                <p class="text-blue-500 font-medium">{{ ucfirst($order->status) }}</p>
                                            </span>

                                        @elseif ($order->status == 'settlement')
                                            <span class="w-28 h-8 bg-green-50 border border-green-300 flex items-center justify-center rounded-lg gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" fill="none">
                                                    <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <p class="text-green-600 font-medium">{{ ucfirst($order->status) }}</p>
                                            </span>
                                        @else
                                        <span class="w-28 h-8 bg-red-50 border border-red-300 flex items-center justify-center rounded-lg gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" fill="none">
                                                <path d="M6 6L18 18M6 18L18 6" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <p class="text-red-600 font-medium">{{ ucfirst($order->status) }}</p>
                                        </span>
                                        @endif
                                    </td>



                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ number_format($order->grand_total, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        @if ($order->status == 'pending')
                                            <button type="button"
                                                class="bg-blue-800 hover:bg-blie-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200"
                                                onclick="redirectToMidtrans('{{ $order->snap_token }}')">
                                                Pay Now
                                            </button>
                                        @elseif ($order->status == 'expired')
                                            <a href="/cancel"
                                                class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 inline-block">
                                                View Details
                                            </a>
                                        @else
                                        <a href="/success/{{ $order->id }}"
                                            class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 inline-block">
                                            View Details
                                        </a>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    function redirectToMidtrans(snapToken) {
        if (!snapToken) {
            alert("Pembayaran tidak tersedia untuk order ini!");
            return;
        }

        snap.pay(snapToken, {
            onSuccess: function(result) {
                console.log("Payment Success:", result);
                window.location.href = "/success";
            },
            onPending: function(result) {
                console.log("Payment Pending:", result);
                alert("Pembayaran masih pending, silakan selesaikan pembayaran.");
            },
            onError: function(result) {
                console.log("Payment Error:", result);
                alert("Terjadi kesalahan dalam pembayaran. Silakan coba lagi.");
            }
        });
    }
</script>


