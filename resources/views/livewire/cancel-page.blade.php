<div class="w-full h-[100vh] flex items-center justify-around flex-col p-5 ">
    <div class="w-[500px] h-[100%] flex items-center justify-around flex-col p-5 rounded-2xl shadow-2xl shadow-black">
        <img src="{{ asset('assets/img/img-cancel-page.jpg') }}" alt="" class="w-[300px]">
        <div class="flex flex-col items-center justify-center gap-4">
            <p class="font-semibold text-[20px]">Payment failed</p>
            <p class="opacity-50">please check your internet connection</p>
        </div>
        <button class="w-36 h-10 bg-red-500 rounded-lg  ">
            <a href="{{ route('products') }}">
                <p class="font-bold text-white">Back Shopping</p>
            </a>
        </button>
    </div>
</div>
