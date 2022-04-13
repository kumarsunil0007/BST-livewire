<x-slot name="header">
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tasks
    </h2> --}}
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="flex justify-between table-heading my-3  px-3">
                <h4 class="flex justify-center items-center font-bold ">View Task</h4>
            </div>
            @if ($task->taskStatus)
                <form class="w-full max-w-lg  ">
                    @if (Auth::user()->hasRole('admin'))
                        <div class="md:flex md:items-center mb-4">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4"
                                    for="inline-full-name">User Name</label>
                                <input
                                    class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                    id="inline-full-name" type="text"
                                    value="{{ $task->taskStatus && $task->taskStatus->user ? $task->taskStatus->user->name : 'N/A' }}"
                                    readonly>
                            </div>
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4"
                                    for="inline-full-name">User Email</label>
                                <input
                                    class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                    id="inline-full-name" type="text"
                                    value="{{ $task->taskStatus && $task->taskStatus->user ? $task->taskStatus->user->email : 'N/A' }}"
                                    readonly>
                            </div>
                        </div>
                    @endif
                    <div class="md:flex md:items-center mb-4">

                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4"
                                for="inline-full-name">Task Name</label>
                            <input
                                class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                id="inline-full-name" type="text" value="{{ ucwords($task->name) }}" readonly>
                        </div>
                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4"
                                for="inline-full-name">No of Images</label>
                            <input
                                class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                id="inline-full-name" type="text" value="{{ $task->no_of_images }}" readonly>
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-4">
                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4"
                                for="inline-full-name">Start Time</label>
                            <input
                                class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                id="inline-full-name" type="text"
                                value="{{ date('d-m-Y', strtotime($task->taskStatus->created_at)) }}" readonly>
                        </div>
                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4"
                                for="inline-full-name">Submit Time</label>
                            <input
                                class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                id="inline-full-name" type="text"
                                value="{{ date('d-m-Y', strtotime($task->taskStatus->updated_at)) }}" readonly>
                        </div>
                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4"
                                for="inline-full-name">Status</label>
                            <input
                                class="bg-gray-100 appearance-none border-2 border-gray-200 rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                id="inline-full-name" type="text"
                                value="{{ $task->taskStatus->is_completed == 0 ? 'In progress' : 'Completed' }}"
                                readonly>
                        </div>
                    </div>
                    <div class="md:flex md:items-center mb-4">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4"
                                for="inline-full-name">Description</label>
                            <textarea class="bg-gray-100 form-control block w-full px-2 py-1.5  text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                id="exampleFormControlTextarea1" rows="3" placeholder="Your message"
                                readonly>{{ ucfirst($task->description) }}</textarea>
                        </div>
                        <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                            <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4"
                                for="inline-full-name">Image Provider</label>
                            <p>{{ $task->taskStatus ? $task->taskStatus->source : 'N/A' }}</p>

                        </div>
                    </div>
                </form>

                <section class="overflow-hidden text-gray-700 ">
                    <div class="container px-4 py-2 mx-auto ">
                        <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4"
                            for="inline-full-name">Selected Images</label>
                        <div class="flex flex-wrap -m-1 md:-m-2">

                            @forelse ($task->taskImages as $image)
                                <a href="javascript:void(0)"
                                    wire:click="selectImage({{ $image['id'] }},'{{ $image['title'] }}','{{ $image['previewUrl'] }}','{{ $image['thumbnailUrl'] }}')"
                                    class="flex flex-wrap w-2/3">
                                    <div class="w-full p-1 md:p-2">
                                        <img alt="gallery"
                                            class="block object-cover object-center w-full h-full rounded-lg"
                                            src="{{ $image['image_thumbnail_url'] }}">
                                    </div>
                                </a>
                            @empty
                                <div>No images to display</div>
                            @endforelse
                        </div>
                </section>
            @else
                <div class="flex">
                    <div>Status: </div>
                    <div>Not started yet</div>
                </div>
                <div class="flex">
                    <div>Task Name: </div>
                    <div>{{ ucwords($task->name) }}</div>
                </div>
                <div class="flex">
                    <div>No of images: </div>
                    <div>{{ ucwords($task->no_of_images) }}</div>
                </div>
                <div class="flex">
                    <div>Description: </div>
                    <div>{{ ucwords($task->description) }}</div>
                </div>
                <div class="flex">
                    <div>Image Provider: </div>
                    <p>{{ $task->taskStatus ? $task->taskStatus->source : 'N/A' }}</p>
                </div>
            @endif

        </div>
    </div>
</div>
