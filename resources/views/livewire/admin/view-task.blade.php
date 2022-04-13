<x-slot name="header">
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tasks
    </h2> --}}
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="flex justify-between table-heading">
                <h4 class="flex justify-center items-center font-bold pb-4">View</h4>
                <a href="{{ route('admin.task') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">
                    Back
                </a>
            </div>
            @if ($task->taskStatus)

                <div class="flex">
                    <div>Staff Name: </div>
                    <div>{{ $task->taskStatus->user->name }}</div>
                </div>
                <div class="flex">
                    <div>Staff Email: </div>
                    <div>{{ $task->taskStatus->user->email }}</div>
                </div>
                <div class="flex">
                    <div>Status: </div>
                    <div>{{ $task->taskStatus->is_completed == 0 ? 'In progress' : 'Completed' }}</div>
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
                @if ($task->taskStatus->is_completed == 0)
                    <div class="flex">
                        <div>Start Date: </div>
                        <div>{{ date('d-m-Y', strtotime($task->taskStatus->created_at)) }}</div>
                    </div>
                @endif
                @if ($task->taskStatus->is_completed == 1)
                    <div class="flex">
                        <div>Submission Date: </div>
                        <div>{{ date('d-m-Y', strtotime($task->taskStatus->updated_at)) }}</div>
                    </div>
                @endif
                <div class="flex">
                    <div>Image Provider: </div>
                    <div>{{ ucwords($task->taskStatus->source) }}</div>
                </div>


                <section class="overflow-hidden text-gray-700 ">
                    <div class="container px-5 py-2 mx-auto lg:pt-12 lg:px-32">
                        <div class="flex flex-wrap -m-1 md:-m-2">
                            @forelse ($task->taskImages as $image)
                                <a href="javascript:void(0)" class="flex flex-wrap w-1/3">
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
                    <div>Shutter Stock</div>
                </div>
            @endif

        </div>
    </div>
</div>
