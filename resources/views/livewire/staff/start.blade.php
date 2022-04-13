{{-- <div>
    <div class="flex flex-col items-center">
        <div class="w-full md:w-1/2 flex flex-col items-center h-64">
            <div class="w-full px-4">
                <div x-data="selectConfigs()" x-init="fetchOptions()" class="flex flex-col items-center relative">
                    <div class="w-full">
                        <div @click.away="close()" class="my-2 p-1 bg-white flex border border-gray-200 rounded">
                            <input x-model="filter" x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                @mousedown="open()" @keydown.enter.stop.prevent="selectOption()"
                                @keydown.arrow-up.prevent="focusPrevOption()"
                                @keydown.arrow-down.prevent="focusNextOption()"
                                class="p-1 px-2 appearance-none outline-none w-full text-gray-800" id="select-option">
                            <div class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200">
                                <button @click="toggle()"
                                    class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline x-show="!isOpen()" points="18 15 12 20 6 15"></polyline>
                                        <polyline x-show="isOpen()" points="18 15 12 9 6 15"></polyline>
                                    </svg>

                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div x-show="isOpen()"
        class="absolute shadow bg-white top-100 z-40 w-full lef-0 rounded max-h-select overflow-y-auto svelte-5uyqqj image-section">
        <div class="flex flex-col w-full">
            <template x-for="(option, index) in filteredOptions()" :key="index">
                <div @click="onOptionClick(index)" :class="classOption(option.login.uuid, index)"
                    :aria-selected="focusedOptionIndex === index">
                    <div
                        class="flex w-full items-centster p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                        <div class="w-6 flex flex-col items-center">
                            <div
                                class="flex relative w-5 h-5 bg-orange-500 justify-center items-center m-1 mr-2 w-4 h-4 mt-1 rounded-full ">
                                <img class="rounded-full" alt="A" x-bind:src="option.picture.thumbnail"> </div>
                        </div>
                        <div class="w-full items-center flex">
                            <div class="mx-2 -mt-1"><span
                                    x-text="option.name.first + ' ' + option.name.last"></span>
                                <div class="text-xs truncate w-full normal-case font-normal -mt-1 text-gray-500"
                                    x-text="option.email"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div> --}}


<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">

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
                                <div class="flex flex-wrap w-1/3">
                                    <div class="w-full p-1 md:p-2">
                                        <img alt="gallery" class="block object-cover object-center w-full h-full rounded-lg" src="{{ $image['thumbnailUrl'] }}">
                                        <input type="text" wire.model="ids" value="{{$image['id']}}">
                                    </div>
                                </div>
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
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button wire:click="closeModal()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Cancel
                        </button>
                    </span>
                </div>
            </form>
        </div>

    </div>
</div>
</div>
