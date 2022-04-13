<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('success'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                    role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-red-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                    role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            <form>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <label for="search" class="block text-gray-700 text-sm font-bold mb-2">Search Collection:</label>
                    <div class="flex">
                        <div class="mb-4 w-full">
                            <input type="search"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="search" placeholder="Enter Keyword" wire:model.defer="keyword">
                            @error('keyword')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <button wire:click.prevent="searchImage()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-8 py-3 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5 w-12 h-10 ms-2">
                            Search
                        </button>
                    </div>
                </div>
                {{-- Image List --}}
                <section class="overflow-hidden text-gray-700 ">
                    <div class="container px-5 py-2 mx-auto lg:pt-12 lg:px-32">
                        <div class="flex flex-wrap -m-1 md:-m-2">
                            @forelse ($images as $image)
                                <a href="javascript:void(0)" wire:click="selectImage({{ $image['id'] }},'{{$image["title"]}}','{{$image["previewUrl"]}}','{{$image["thumbnailUrl"]}}')"
                                    class="flex flex-wrap w-1/3">
                                    <div class="w-full p-1 md:p-2">
                                        <img alt="gallery"
                                            class="block object-cover object-center w-full h-full rounded-lg"
                                            src="{{ $image['thumbnailUrl'] }}">
                                    </div>
                                </a>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </section>

                {{-- Selected Image --}}
                <section class="overflow-hidden text-gray-700 ">
                    <div class="container px-5 py-2 mx-auto lg:pt-12 lg:px-32">
                        <div class="flex flex-wrap -m-1 md:-m-2">
                            @forelse ($imageStocks as $image)
                                <a href="javascript:void(0)" 
                                    class="flex flex-wrap">
                                    <div class="p-1 md:p-2 relative">
                                        <div style="position:absolute;right:10px;top:5px;padding:5px;" wire:click.prevent="removeImage({{ $image['image_id'] }},'{{$image["image_title"]}}','{{$image["image_preview_url"]}}','{{$image["image_thumbnail_url"]}}')">x</div>
                                        <img alt="gallery" class="rounded" src="{{ $image['image_thumbnail_url'] }}" style="width: 70px; height:70px;">
                                    </div>
                                </a>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </section>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="store()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Save
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <a href="{{ route('staff.allTask') }}"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Cancel
                        </a>
                    </span>
                    <div x-data="{ show: false }" x-init="setTimeout(() => show = false, 3000)"
                        class="bg-green-200 text-black mr-4 px-2" style="display: none;">
                        {{ session('message') }}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
