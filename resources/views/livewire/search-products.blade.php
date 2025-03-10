<div x-data="searchComponent()">
    <!-- Tombol Search -->
    <div id="open-search" @click="openSearch()"
        class="size-8 bg-slate-200 overflow-hidden flex items-center justify-center rounded-xl cursor-pointer hover:bg-slate-300 transition">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="fill-slate-700">
            <path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"/>
        </svg>
    </div>

    <!-- Modal Search -->
    <div id="search-modal" x-show="isSearchOpen"
    @click.away="closeSearch()"
    class="fixed inset-0 bg-black bg-opacity-50 w-full flex items-center justify-center transition-opacity duration-300 ease-in-out">
        <div class="bg-white w-[90%] md:w-[600px] p-5 rounded-lg shadow-lg max-h-[70vh] overflow-hidden flex flex-col">
            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">Search Products</h2>
                <button @click="closeSearch()" class="text-red-500 font-bold text-xl">&times;</button>
            </div>

            <!-- Input Search -->
            <input wire:model.live.throttle.500ms="search" type="text" placeholder="Search..."
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">

            <!-- Search Results -->
            <div class="mt-4 space-y-3 overflow-y-auto max-h-[50vh]">
                @if (strlen($search) > 2)
                    @foreach ($results as $result)
                        <a href="/products/{{ $result->slug }}">
                            <div class="flex items-center space-x-3 p-2 bg-gray-100 rounded-md hover:bg-gray-200 transition cursor-pointer">
                                <img src="{{ isset($result->images[0]) ? url('storage/', $result->images[0]) : asset('default-image.png') }}"
                                class="w-12 h-12 rounded-md" alt="Product">
                                <div>
                                    <h3 class="text-sm font-medium">{{ $result->name }}</h3>
                                    @if ($result instanceof \App\Models\Product)
                                        <p class="text-xs text-gray-500">{{ Number::currency($result->price, 'IDR') }}</p>
                                    @else
                                        <p class="text-xs text-gray-500">Category</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <p class="text-sm text-gray-500">No results found.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function searchComponent() {
    return {
        isSearchOpen: false, // Default modal tertutup

        openSearch() {
            this.isSearchOpen = true;
        },
        closeSearch() {
            this.isSearchOpen = false;
        }
    }
}
</script>
