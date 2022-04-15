<div class="">
    <nav class="flex py-3 px-5 text-gray-700 bg-dark-blue" aria-label="Breadcrumb">
        <div class="container mx-auto">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <div class="inline-flex items-center text-sm font-medium text-white hover:text-white">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                            </path>
                        </svg>
                        Home
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-1 text-sm font-medium text-white">My Task</div>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a href="#" class="ml-1 text-sm font-medium text-white">Task Details</a>
                    </div>
                </li>
            </ol>
        </div>
    </nav>
    <div class="container mx-auto py-12">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="flex justify-end table-heading my-3  px-3">
                <a href="{{ request()->routeIs('admin.*') ? route('admin.task') : route('staff.myTask') }}"
                    class="bg-dark-blue hover:bg-blue-700 text-white font-medium py-2 px-4 text-sm rounded my-3">Back</a>
            </div>
            <div class="flex justify-between table-heading">
                <h5 class="flex justify-start items-start text-lg font-bold text-gray-700 bg-gray-100 py-2 w-full px-3">
                    Task Details</h5>
            </div>
            <hr>
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
            <div class="md:flex items-start mb-4 mt-4">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block text-gray-500 font-medium md:text-left text-sm mb-1 md:mb-3 pr-4"><strong>Task
                            Name :
                        </strong>{{ ucwords($task->name) }} </label>
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block text-gray-500 font-medium md:text-left text-sm mb-1 md:mb-3 pr-4"><strong>No. of
                            images
                            : </strong>{{ ucwords($task->no_of_images) }}
                    </label>
                </div>

            </div>
            <div class="md:flex items-start mb-4 mt-4">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block text-gray-500 font-medium md:text-left text-sm mb-1 md:mb-3 pr-4"
                        for="inline-full-name"><strong>Status :</strong> <span
                            class="inline-flex items-center justify-center px-2 py-1 text-sm font-medium leading-none text-white bg-dark-blue rounded-full">{{ $task->taskStatus->is_completed == 0 ? 'In progress' : 'Completed' }}</span></label>
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block text-gray-500 font-medium md:text-left text-sm mb-1 md:mb-3 pr-4"><strong>Image
                            Provider
                            : </strong>{{ $setting ? ucwords($setting->source_name) : 'N/A' }}
                    </label>
                </div>
            </div>
            <div class="md:flex items-start mb-4">

                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block text-gray-500 font-medium md:text-left text-sm mb-1 md:mb-3 pr-4"><strong>Description
                            :
                        </strong>{{ ucwords($task->description) }}
                    </label>
                </div>
            </div>

            <form x-data="{ open: false, pagination: false }">
                <div>
                    <div class="bg-white pt-5 pb-4">
                        <div class="flex justify-between table-heading">
                            <h5
                                class="flex justify-start items-start text-lg font-bold text-gray-700 bg-gray-100 py-2 w-full px-3">
                                Search Collection</h5>
                        </div>
                        <hr>
                        <div class="my-4 pt-5 ">
                            <div class="md:flex justify-center items-center mb-4 mt-4">
                                <input type="search"
                                    class="appearance-none border border-r-0 rounded-l-md w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none"
                                    id="search" placeholder="Enter Keyword" wire:model.defer="keyword">

                                <button wire:click.prevent="searchImage()" type="button"
                                    @click="open = true;pagination = true"
                                    class="inline-flex justify-center w-full rounded-r-md border bg-dark-blue border-gray-300 w-20 px-8 py-2 bg-white text-white leading-6 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300  transition ease-in-out duration-150 sm:text-sm sm:leading-5 w-12 h-10 ms-2">
                                    Search
                                </button>
                            </div>
                            @error('keyword')
                                <div class="text-red-500 text-sm mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
                {{-- Selected image List --}}
                <section class="overflow-hidden text-gray-700 ">
                    @if ($imageStocks)
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
                    @endif
                </section>
                {{-- Image list --}}

                @if ($images)
                    <section class="overflow-hidden text-gray-700 ">
                        <div class="container px-2 py-2 mx-auto ">
                            <div class="flex flex-wrap -m-1 md:-m-2">
                                @if ($setting->source_url == 'https://www.shutterstock.com')
                                    @forelse ($images as $image)
                                        <a href="javascript:void(0)"
                                            wire:click="selectImage({{ $image['id'] }},'{{ $image['description'] }}','{{ $image['assets']['preview']['url'] }}','{{ $image['assets']['large_thumb']['url'] }}')"
                                            class="flex flex-wrap w-1/5  mb-5 search-images">
                                            <div class="flex p-1 md:p-2 w-full">
                                                <img alt="gallery"
                                                    class="border block object-cover object-center rounded-lg w-full"
                                                    src="{{ $image['assets']['large_thumb']['url'] }}">
                                            </div>
                                        </a>
                                    @empty
                                    @endforelse
                                @elseif ($setting->source_url == 'https://www.storyblocks.com')
                                    @forelse ($images as $image)
                                        <a href="javascript:void(0)"
                                            wire:click="selectImage({{ $image['id'] }},'{{ $image['title'] }}','{{ $image['preview_url'] }}','{{ $image['thumbnail_url'] }}')"
                                            class="flex flex-wrap w-1/5  mb-5 search-images">
                                            <div class="flex p-1 md:p-2 w-full">
                                                <img alt="gallery"
                                                    class="block border object-cover object-center rounded-lg w-full"
                                                    src="{{ $image['thumbnail_url'] }}">
                                            </div>
                                        </a>
                                    @empty
                                    @endforelse
                                @endif
                            </div>
                        </div>
                    </section>

                    <div x-show="pagination">
                        <div class="flex items-center space-x-1 justify-end py-3">
                            <button type="button" wire:click.prevent="previous()"
                                class="flex items-center px-4 py-2 text-gray-500 bg-gray-300 rounded-md"
                                {{ $previousBtnDisable }}>
                                Previous
                            </button>
                            <button type="button" wire:click.prevent="next()"
                                class="px-4 py-2 font-bold text-gray-500 bg-gray-300 rounded-md hover:bg-blue-400"
                                {{ $nextBtnDisable }}>
                                Next
                            </button>
                        </div>
                    </div>

                    <div x-show="open">
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button wire:click.prevent="store()" type="button"
                                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-dark-blue text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Save
                                </button>
                            </span>
                            <div x-data="{ show: false }" x-init="setTimeout(() => show = false, 3000)"
                                class="bg-green-200 text-black mr-4 px-2" style="display: none;">
                                {{ session('message') }}
                            </div>               
                        </div>
                    </div>
                @else
                    {!! $resultMessage !!}
                @endif

            </form>
        </div>
    </div>
</div>
