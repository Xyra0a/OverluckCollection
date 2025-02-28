<div>

    <section class="w-full h-[400px] flex items-center justify-center overflow-hidden bg-[url('{{ asset('../../') }}')] bg-cover py-10 max-[660px]:h-auto">
      <div class="w-[80%] h-full bg-white flex rounded-2xl max-[660px]:flex-col">
        <div class="w-[50%] h-full flex flex-col items-start justify-end rounded-2xl p-10 max-[660px]:w-full">
          <h1 class="font-bold text-3xl text-[#384B70]">Overluck Collection</h1>
          <p class="font-medium text-[#384B70]">sell many designs of hoodie , shirt and others</p>
        </div>
        <div class="w-[50%] h-full flex justify-end items-end p-10 max-[660px]:w-full max-[660px]:justify-start">
          <button class="w-24 h-10 bg-[#F8E1B7] rounded-xl">
            <a href="" class="text-[#384B70] font-medium">
              Buy Now
            </a>
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
                    <a href="#" class="flex flex-col items-center">
                        <img src="{{ url('storage/'.$category->image) }}" alt="{{ $category->name }}" class="w-full h-[180px] object-cover rounded-lg">
                        <p class="mt-2">{{ $category->name }}</p>
                    </a>
                </button>
            @endforeach
        </div>
    </div>
      <div class="w-full h-[450px] flex items-center flex-col max-[802px]:h-[700px] max-[525px]:h-[1040px]">
        <div class="w-full h-10 flex justify-center items-center">
          <h1 class="text-3xl font-bold text-font1">Products</h1>
        </div>
        <div class="w-[80%] h-[350px] flex justify-around items-center flex-wrap gap-5">
            @foreach ($products as $product)
            <div class="w-[200px] h-[315px] bg-font2 flex justify-start items-start rounded-2xl flex-col">
                <img src="{{ url('storage/',$product->images[0]) }}" class="rounded-t-2xl w-full h-[240px] bg-slate-300" alt="">
                <h1 class="font-bold text-[15px] items-center w-auto px-2">{{ $product->name }}</h1>
                <div class="flex px-2">
                    <span class="text-sm font-medium text-green-500">{{ Number::currency($product->price, 'IDR') }}</span>
                </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
