<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="flex items-center font-poppins dark:bg-gray-800 ">
        <div class="justify-center flex-1 max-w-6xl px-4 py-4 mx-auto bg-white border rounded-md dark:border-gray-900 dark:bg-gray-900 md:py-10 md:px-10">
          <div>
            <h1 class="px-4 mb-8 text-2xl font-semibold tracking-wide text-gray-700 dark:text-gray-300 ">
              Thank you. Your order has been received. </h1>
            <div class="flex border-b border-gray-200 dark:border-gray-700  items-stretch justify-start w-full h-full px-4 mb-8 md:flex-row xl:flex-col md:space-x-6 lg:space-x-8 xl:space-x-0">
              <div class="flex items-start justify-start flex-shrink-0">
                <div class="flex items-center justify-center w-full pb-6 space-x-4 md:justify-start">
                  <div class="flex flex-col items-start justify-start space-y-2">
                    <p class="text-lg font-semibold leading-4 text-left text-gray-800 dark:text-gray-400">
                      {{ Auth::user()->name }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex flex-wrap items-center pb-4 mb-10 border-b border-gray-200 dark:border-gray-700">
              <div class="w-full px-4 mb-4 md:w-1/4">
                <p class="mb-2 text-sm leading-5 text-gray-600 dark:text-gray-400 ">
                  Order Number: </p>
                <p class="text-base font-semibold leading-4 text-gray-800 dark:text-gray-400">
                 {{ $order->id }}</p>
              </div>
              <div class="w-full px-4 mb-4 md:w-1/4">
                <p class="mb-2 text-sm leading-5 text-gray-600 dark:text-gray-400 ">
                  Date: </p>
                <p class="text-base font-semibold leading-4 text-gray-800 dark:text-gray-400">
                 {{ $order->created_at }}</p>
              </div>
              <div class="w-full px-4 mb-4 md:w-1/4">
                <p class="mb-2 text-sm font-medium leading-5 text-gray-800 dark:text-gray-400 ">
                  Total: </p>
                <p class="text-base font-semibold leading-4 text-blue-600 dark:text-gray-400">
               {{  Number::currency($order->grand_total, 'IDR')}}</p>
              </div>
              <div class="w-full px-4 mb-4 md:w-1/4">
                <p class="mb-2 text-sm leading-5 text-gray-600 dark:text-gray-400 ">
                  Payment Method: </p>
                  <p class="text-base font-semibold leading-4 text-gray-800 dark:text-gray-400">
                    {{ strtoupper($order->payment_type ?? 'N/A') }}
                </p>

              </div>
            </div>
            <div class="px-4 mb-10">
              <div class="flex flex-col items-stretch justify-center w-full space-y-4 md:flex-row md:space-y-0 md:space-x-8">
                <div class="flex flex-col w-full space-y-6 ">
                    @foreach ($order->items as $item)
                    <h2 class="mb-2 text-xl font-semibold text-gray-700 dark:text-gray-400">Order details</h2>
                    <div class="flex flex-col items-center justify-center w-full pb-4 space-y-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between w-full">
                        <p class="text-base leading-4 text-gray-800 dark:text-gray-400">Subtotal</p>
                        <p class="text-base leading-4 text-gray-600 dark:text-gray-400">{{ Number::currency($item->unit_amount, 'IDR') }}</p>
                        </div>
                        <div class="flex items-center justify-between w-full">
                        <p class="text-base leading-4 text-gray-800 dark:text-gray-400">Taxes
                        </p>
                        <p class="text-base leading-4 text-gray-600 dark:text-gray-400">{{ Number::currency($item->taxes, 'IDR') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between w-full">
                        <p class="text-base font-semibold leading-4 text-gray-800 dark:text-gray-400">Total</p>
                        <p class="text-base font-semibold leading-4 text-gray-600 dark:text-gray-400">{{ Number::currency($item->total_amount, 'IDR') }}</p>
                    </div>
                    </div>
                @endforeach
              </div>
            </div>
            <div class="flex items-center justify-start gap-4 px-4 mt-6">
                <a href="/products"
                    class="w-full text-center px-4 py-2 text-blue-500 border border-blue-500 rounded-md md:w-auto
                          hover:text-white hover:bg-blue-600 dark:border-gray-700 dark:hover:bg-gray-700 dark:text-gray-300">
                    Go back shopping
                </a>

                @php
                    $imageUrls = []; // Kumpulkan semua URL gambar di sini
                @endphp

                @if ($order->status == 'settlement')
                    @foreach ($order->items as $item)
                        @php
                            // Pastikan images adalah array
                            $images = is_array($item->product->images) ? $item->product->images : json_decode($item->product->images, true);

                            // Tambahkan semua gambar ke dalam array imageUrls
                            if (!empty($images) && is_array($images)) {
                                foreach ($images as $image) {
                                    $imageUrls[] = Storage::url(trim($image)); // Trim untuk menghapus spasi yang tidak perlu
                                }
                            }
                        @endphp
                    @endforeach

                    @if (!empty($imageUrls))
                        <button onclick="downloadImages()"
                            class="w-full text-center px-4 py-2 bg-blue-500 rounded-md text-gray-50 md:w-auto
                                    dark:text-gray-300 hover:bg-blue-600 dark:hover:bg-gray-700 dark:bg-gray-800">
                            Download My Design
                        </button>

                        <script>
                            function downloadImages() {
                                let imageUrls = @json($imageUrls);

                                if (imageUrls.length === 0) {
                                    alert("Tidak ada file untuk didownload.");
                                    return;
                                }

                                imageUrls.forEach((url, index) => {
                                    setTimeout(() => {
                                        let a = document.createElement("a");
                                        a.href = url;
                                        a.download = "design_" + (index + 1) + url.substring(url.lastIndexOf('.'));
                                        document.body.appendChild(a);
                                        a.click();
                                        document.body.removeChild(a);
                                    }, index * 1500); // Tambah jeda agar tidak diblokir
                                });
                            }
                        </script>
                    @else
                        <span class="text-gray-500">Tidak ada desain yang tersedia untuk diunduh.</span>
                    @endif
                @else
                    <span class="text-gray-500">Menunggu pembayaran...</span>
                @endif
            </div>


          </div>
        </div>
      </section>

</div>
