<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
        Checkout
    </h1>
    <div class="flex flex-col gap-4">
        <div class="md:col-span-12 lg:col-span-4 col-span-12">
            <!-- Basket Summary -->
            <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                    BASKET SUMMARY
                </div>
                <ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
                    @foreach ($items as $item)
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img alt="Product image" class="w-12 h-12 rounded-full" src="{{ url('storage/', $item['images']) }}">
                                </div>
                                <div class="flex-1 min-w-0 ms-4">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $item['name'] }}
                                    </p>
                                </div>
                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    {{ Number::currency($item['unit_amount'], 'IDR') }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900 my-4">
                <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                    ORDER SUMMARY
                </div>
                <div class="flex justify-between mb-2 font-bold">
                    <span>Subtotal</span>
                    <span>{{ Number::currency($grand_total, 'IDR') }}</span>
                </div>
                <div class="flex justify-between mb-2 font-bold">
                    <span>Taxes (11%)</span>
                    <span>{{ Number::currency($grand_total * 0.11, 'IDR') }}</span>
                </div>
                <hr class="bg-slate-400 my-4 h-1 rounded">
                <div class="flex justify-between mb-2 font-bold">
                    <span>Grand Total</span>
                    <span>{{ Number::currency($grand_total * 1.11, 'IDR') }}</span>
                </div>
            </div>

            <!-- Payment Button -->
            <button type="button" class="bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-600" id="pay-button">
                Place Order
            </button>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        // var resultType = document.getElementById('result-type');

        snap.pay('{{ $snap_token }}', {
            onSuccess: function(result) {
                console.log(result);
                window.location.href = '/success';
            },
            onPending: function(result) {
                resultType.innerHTML = 'Result: ' + result.status;
            },
            onError: function(result) {
                resultType.innerHTML = 'Result: ' + result.status;
            }
        });
    }
</script>
