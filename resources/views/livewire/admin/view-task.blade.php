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
                <form class="w-full ">
                    
                        <div class="md:flex md:items-center mb-4">
                        @if (Auth::user()->hasRole('admin'))
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
                            @endif
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
                       <div class="md:w-1/2 px-3 mb-6 md:mb-4">
                            <label class="block text-gray-500 font-bold md:text-left mb-3 pr-4"
                                for="inline-full-name">Image Provider</label>
                            <!-- <p>{{ $task->taskStatus ? $task->taskStatus->source : 'N/A' }}</p> -->
                            <div class="flex justify-content-between mt-3">
                                <div class="form-check mr-4">
                                <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault1">
                                    Shutter Stock
                                </label>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault2">
                                    Story Block
                                </label>
                                </div>
                            </div>
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
                      
                    </div>
                </form>

                <section class="overflow-hidden text-gray-700 ">
                    <div class="container px-4 py-2 mx-auto ">
                        <label class="block text-gray-500 font-bold md:text-left mb-4 pr-4"
                            for="inline-full-namemb-4">Selected Images</label>
                        <div class="flex flex-wrap -m-1 md:-m-2">

                            @forelse ($task->taskImages as $image)
                            <!-- <a href="javascript:void(0)"
                                    wire:click="selectImage({{ $image['id'] }},'{{ $image['title'] }}','{{ $image['previewUrl'] }}','{{ $image['thumbnailUrl'] }}')"
                                    class="flex w-2/5 bg-slate-300 border-2 border-solid mr-2">
                                    <div class="w-full p-1 md:p-2">
                                        <img alt="gallery"
                                            class="block object-cover object-center w-full h-full rounded-lg"
                                            src="{{ $image['image_thumbnail_url'] }}">
                                    </div>
                                </a> -->
                                <a href="javascript:void(0)"
                                    class="flex w-2/5 bg-slate-300 border-2 border-solid mr-2">
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
