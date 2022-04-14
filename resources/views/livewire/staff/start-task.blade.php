<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="flex justify-between table-heading my-3  px-3">
                <h4 class="flex justify-center items-center font-bold ">Task Details</h4>
                <a href="{{ request()->routeIs('admin.*') ? route('admin.task') : route('staff.myTask') }}"
                    class="bg-dark-blue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Back</a>
            </div>
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
                <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-3"
                    role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="md:flex md:items-center mb-4">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4">Task Name: </label>

                    <input
                        class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                        id="inline-full-name" type="text" value="{{ ucwords($task->name) }}" readonly>
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4">No. of images:
                    </label>
                    <input
                        class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                        id="inline-full-name" type="text" value="{{ ucwords($task->no_of_images) }}" readonly>
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4"
                        for="inline-full-name">Status</label>
                    <input
                        class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                        id="inline-full-name" type="text"
                        value="{{ $task->taskStatus->is_completed == 0 ? 'In progress' : 'Completed' }}" readonly>
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4">Image Provider:
                    </label>
                    <input
                        class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                        id="inline-full-name" type="text"
                        value="{{ $task->taskStatus ? ucwords($task->taskStatus->source) : 'N/A' }}" readonly>

                </div>
            </div>
            <div class="md:flex md:items-center mb-4">

                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4">Description:
                    </label>
                    <textarea class="bg-gray-100 form-control block w-full px-2 py-1.5  text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        id="exampleFormControlTextarea1" rows="3" placeholder="Your message"
                        readonly>{{ ucwords($task->description) }}</textarea>
                </div>
            </div>
            <hr>

            <form>
                <div x-data="{ open: false }">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <label for="search" class="block text-gray-700 text-lg font-bold mb-2 text-center">Search
                            Collection:</label>
                        <div class="flex justify-center">
                            <div class="mb-4">
                                <input type="search"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="search" placeholder="Enter Keyword" wire:model.defer="keyword">
                                @error('keyword')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <button wire:click.prevent="searchImage()" type="button" @click="open = true"
                                class="inline-flex justify-center w-full rounded-md border bg-purple border-gray-300 px-8 py-2 bg-white text-white leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5 w-12 h-10 ms-2">
                                Search
                            </button>
                        </div>
                    </div>
                    {{-- Image List --}}
                    <section class="overflow-hidden text-gray-700 ">
                        <div class="container px-4 py-2 mx-auto lg:pt-8 lg:px-20">
                            <div class="flex flex-wrap -m-1 md:-m-2">
                                @if ($setting->source_api == 'https://www.shutterstock.com')
                                    @forelse ($images as $image)
                                        <a href="javascript:void(0)"
                                            wire:click="selectImage({{ $image->id }},'{{ $image->description }}','{{ $image->assets->preview->url }}','{{ $image->assets->large_thumb->url }}')"
                                            class="flex flex-wrap w-2/3 search-images">
                                            <div class="w-full p-1 md:p-2">
                                                <img alt="gallery" class="block object-cover object-center rounded-lg"
                                                    src="{{ $image->assets->large_thumb->url }}">
                                            </div>
                                        </a>
                                    @empty
                                    @endforelse
                                @elseif ($setting->source_api == 'https://www.storyblocks.com')
                                @forelse ($images as $image)
                                    <a href="javascript:void(0)"
                                        wire:click="selectImage({{ $image->id }},'{{ $image->title }}','{{ $image->preview_url }}','{{ $image->thumbnail_url }}')"
                                        class="flex flex-wrap w-2/3 search-images">
                                        <div class="w-full p-1 md:p-2">
                                            <img alt="gallery"
                                                class="block object-cover object-center rounded-lg"
                                                src="{{ $image->thumbnail_url }}">
                                        </div>
                                    </a>
                                @empty
                                @endforelse
                                @endif

                            </div>
                        </div>
                    </section>
                    <nav aria-label="pagination">
                        @if ($previousPageUrl)
                            <a href="?page={{ $page - 1 }}">Previous</a>
                        @endif

                        @if ($nextPageUrl)
                            <a href="?page={{ $page + 1 }}">Next</a>
                        @endif
                    </nav>
                    {{-- <div>{{ $images->links() }}</div> --}}
                    {{-- Selected Image --}}
                    <div x-show="open">
                        <section class="overflow-hidden text-gray-700 ">
                            <div class="container px-4 py-2 mx-auto lg:pt-12 ">
                                <div class="flex flex-wrap -m-1 md:-m-2">

                                    @forelse ($imageStocks as $image)
                                        <a href="javascript:void(0)" class="flex flex-wrap">

                                            <div class="p-1 md:p-2 relative">
                                                <div class="remove-image"
                                                    style="position:absolute;right:10px;top:5px;padding:5px;"
                                                    wire:click.prevent="removeImage({{ $image['image_id'] }},'{{ $image['image_title'] }}','{{ $image['image_preview_url'] }}','{{ $image['image_thumbnail_url'] }}')">
                                                    x</div>
                                                <img alt="gallery" class="rounded"
                                                    src="{{ $image['image_thumbnail_url'] }}"
                                                    style="width: 70px; height:70px;">
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
                                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-purple text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Save
                                </button>
                            </span>
                            <div x-data="{ show: false }" x-init="setTimeout(() => show = false, 3000)"
                                class="bg-green-200 text-black mr-4 px-2" style="display: none;">
                                {{ session('message') }}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
