<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="overflow-hidden bg-white py-11 font-poppins dark:bg-gray-800">
      <div class="max-w-6xl px-4 py-4 mx-auto lg:py-8 md:px-6">
        {{-- {{ $product }} --}}
        <div class="flex flex-wrap -mx-4">
          <div class="w-full mb-8 md:w-1/2 md:mb-0" x-data="{ mainImage: '{{ url('storage/',$product->images[0]) }}' }">
            <div class="sticky top-0 z-50 overflow-hidden ">
              <div class="relative mb-6 lg:mb-10 lg:h-2/4 ">
                <img x-bind:src="mainImage" alt="" class="object-cover w-full lg:h-full ">
              </div>
              <div class="flex-wrap hidden md:flex ">
                @foreach ($product->images as $image)

                <div class="w-1/2 p-2 sm:w-1/4" x-on:click="mainImage='{{ url('storage/',$image) }}'">
                  <img src="{{ url('storage/',$image) }}" alt="{{ $product->name }}" class="object-cover w-full lg:h-20 cursor-pointer hover:border hover:border-blue-500">
                </div>
                @endforeach


              </div>
              <div class="px-6 pb-6 mt-6 border-t border-gray-300 dark:border-gray-400 ">
              </div>
            </div>
          </div>
          <div class="w-full px-4 md:w-1/2 ">
            <div class="lg:pl-20">``
              <div class="mb-8 ">
                {{-- [&>ul]:list-disc [&>ul]:ml-4 --}}
                <h2 class="max-w-xl mb-6 text-2xl font-bold dark:text-gray-400 md:text-4xl">
                  {{ $product->name }}</h2>
                <p class="inline-block mb-6 text-4xl font-bold text-gray-700 dark:text-gray-400 ">
                  <span>{{ Number::currency( $product->price, 'IDR')}}</span>
                </p>
                <p class="max-w-md text-gray-700 dark:text-gray-400">
                  {{!! Str::markdown($product->description) !!}}
                </p>
              </div>

              <div class="flex flex-wrap items-center gap-4">
                <button wire:click="addToCart({{ $product->id }})" class="w-full p-4 bg-blue-500 rounded-md lg:w-2/5 dark:text-gray-200 text-gray-50 hover:bg-blue-600 dark:bg-blue-500 dark:hover:bg-blue-700">
                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add to cart</span><span wire:loading wire:target="addToCart({{ $product->id }})">Adding....</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
