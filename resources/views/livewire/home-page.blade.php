<div>
    <section class="w-full h-[500px] flex items-center justify-center overflow-hidden py-10 max-[660px]:h-auto">
        <div class="w-[80%] h-full bg-white flex rounded-2xl max-[660px]:flex-col bg-[url('http://127.0.0.1:8000/assets/img/bg-home-hd.png')] bg-center bg-cover">
            <div class="w-[50%] h-full flex flex-col items-start justify-end rounded-2xl p-10 max-[660px]:w-full">
                <h1 class="font-bold text-3xl text-[#384B70]">Overluck Collection</h1>
                <p class="font-medium text-[#384B70]">Sell many designs of hoodie, shirt and others</p>
            </div>
            <div class="w-[50%] h-full flex justify-end items-end p-10 max-[660px]:w-full max-[660px]:justify-start">
                <button class="w    -24 h-10 bg-[#F8E1B7] rounded-xl">
                    <a href="{{ route('products') }}" class="text-[#384B70] font-medium">Buy Now</a>
                </button>
            </div>
        </div>
    </section>

    <div class="w-full h-[450px] flex flex-col items-center max-[770px]:h-auto">
        <div class="w-full flex items-center justify-center">
            <h1 class="font-bold text-3xl text-font1">Categories</h1>
        </div>
        <div class="w-[90%] h-[500px] flex flex-wrap justify-center items-center gap-4 m-5 max-[770px]:flex-col max-[770px]:h-full">
            @foreach ($categories as $category)
                <button class="bg-white w-[170px] h-[270px] p-3 flex flex-col items-center justify-center rounded-xl text-l font-semibold hover:shadow-lg transition-shadow">
                    <a href="{{ route('products', ['selectedCategories' => [$category->id]]) }}" class="flex flex-col items-center">
                        <img src="{{ url('storage/'.$category->image) }}" alt="{{ $category->name }}" class="w-full h-[180px] object-cover rounded-lg">
                        <p class="mt-2">{{ $category->name }}</p>
                    </a>
                </button>
            @endforeach
        </div>
    </div>
    <div class="w-full flex flex-col items-center max-[802px]:h-auto p-4">
        <div class="w-full h-10 flex justify-center items-center mb-4">
            <h1 class="text-3xl font-bold text-font1">Products</h1>
        </div>
        <div class="w-full max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
            <a href="/products/{{ $product->slug }}">
                <div class="bg-font2 rounded-2xl shadow-lg overflow-hidden flex flex-col">
                    <img src="{{ url('storage/', $product->images[0]) }}"
                        class="w-full h-52 object-cover bg-slate-300"
                        alt="{{ $product->name }}">
                    <div class="p-4 flex flex-col flex-grow">
                        <h1 class="font-semibold text-lg text-gray-800 truncate">{{ $product->name }}</h1>
                        <span class="text-sm font-medium text-green-500 mt-2">{{ Number::currency($product->price, 'IDR') }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="flex justify-center mt-6">
            <a class="relative" href="{{ route('products') }}">
                <span class="absolute top-0 left-0 mt-1 ml-1 h-full w-full rounded bg-black"></span>
                <span class="fold-bold relative inline-block h-full w-full rounded border-2 border-black bg-white px-4 py-2 text-base font-bold text-black transition duration-100 hover:bg-gray-400 hover:text-gray-900">View More</span>
            </a>
        </div>
    </div>
      </div>
    </div>
