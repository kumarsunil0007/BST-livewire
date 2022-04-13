<x-slot name="header">
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tasks
    </h2> --}}
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <form class="w-full max-w-sm">
                <div class="md:flex md:items-center mb-6">
                    <div class="w-full">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                            for="inline-full-name">
                            User Name
                        </label>
                    </div>
                    <div class="w-full">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="inline-full-name" type="text" value="{{ $task->taskStatus->user->email }}" readonly>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="w-full">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                            for="inline-full-name">
                            Task Name
                        </label>
                    </div>
                    <div class="w-full">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="inline-full-name" type="text" value="{{ ucwords($task->name) }}" readonly>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="w-full">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                            for="inline-full-name">
                            Description
                        </label>
                    </div>
                    <div class="w-full">
                        <textarea class="form-control block w-full px-3 py-1.5  text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            id="exampleFormControlTextarea1" rows="3"
                            placeholder="Your message" readonly>{{ ucfirst($task->description) }}</textarea>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="w-full">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                            for="inline-full-name">
                            No of Images
                        </label>
                    </div>
                    <div class="w-full">
                        <input
                            class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="inline-full-name" type="text" value="{{ $task->no_of_images }}" readonly>
                    </div>
                </div>
            </form>

            <section class="overflow-hidden text-gray-700 ">
                <div class="container px-5 py-2 mx-auto lg:pt-12 lg:px-32">
                    <div class="flex flex-wrap -m-1 md:-m-2">
                        @forelse ($task->taskImages as $image)
                            <a href="javascript:void(0)"
                                wire:click="selectImage({{ $image['id'] }},'{{ $image['title'] }}','{{ $image['previewUrl'] }}','{{ $image['thumbnailUrl'] }}')"
                                class="flex flex-wrap w-1/3">
                                <div class="w-full p-1 md:p-2">
                                    <img alt="gallery" class="block object-cover object-center w-full h-full rounded-lg"
                                        src="{{ $image['image_thumbnail_url'] }}">
                                </div>
                            </a>
                        @empty
                        <div>No images to display</div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
