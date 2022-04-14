<x-slot name="header">
    
</x-slot>
<div class="">
<nav class="flex py-3 px-5 text-gray-700 bg-dark-blue" aria-label="Breadcrumb">
<div class="container mx-auto">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                <a href="#" class="inline-flex items-center text-sm font-medium text-white hover:text-white">
                    <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    Home
                </a>
                </li>
                <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="#" class="ml-1 text-sm font-medium text-white">Tasks</a>
                </div>
                </li>
                <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="#" class="ml-1 text-sm font-medium text-white">Tasks Details</a>
                </div>
                </li>
            </ol>
     </div>
</nav>
    <div class="container mx-auto py-12">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="flex justify-end table-heading mb-3">
                <a href="{{ request()->routeIs('admin.*') ? route('admin.task') : route('staff.allTask') }}"
                    class="bg-dark-blue hover:bg-dark-blue text-white font-medium text-sm py-2 px-4 rounded my-3">Back</a>
            </div>
            <div class="flex justify-between table-heading mb-3">
                <h5 class="flex justify-start items-start font-bold text-lg text-dark-blue bg-gray-100 w-full px-2 py-2">Task Details</h5>
            </div>
            <hr/>
            @if ($task->taskStatus)
                <form class="w-full pt-5">

                    <div class="md:flex md:items-center mb-4">
                       
                        <div class="md:w-1/2 mb-6 md:mb-0">
                            <label class="block text-gray-500 font-medium text-sm md:text-left mb-1 md:mb-3 pr-4"
                                for="inline-full-name">Task Name : <strong>{{ ucwords($task->name) }}</strong></label>
                            
                        </div>
                        <div class="md:w-1/2 mb-6 md:mb-0">
                            <label class="block text-gray-500 font-medium text-sm md:text-left mb-1 md:mb-3 pr-4"
                                for="inline-full-name">Status : <span class="inline-flex items-center justify-center px-2 py-1 text-sm font-medium leading-none text-white bg-dark-blue rounded-full">{{ $task->taskStatus->is_completed == 0 ? 'In progress' : 'Completed' }}</span></label>
                           
                        </div>
                        @if (($task->taskStatus && $task->taskStatus->user_id == Auth::user()->id) || Auth::user()->hasRole('admin'))
                            <div class="md:w-1/2 mb-6 md:mb-0">
                                <label class="block text-gray-500 font-medium text-sm md:text-left mb-1 md:mb-3 pr-4"
                                    for="inline-full-name">Start Date : <strong>{{ date('d-m-Y', strtotime($task->taskStatus->created_at)) }}</strong></label>
                            </div>
                            <div class="md:w-1/2 mb-6 md:mb-0">
                                <label class="block text-gray-500 font-medium text-sm md:text-left mb-2 md:mb-3 pr-4"
                                    for="inline-full-name">Submit Date : <strong>{{ date('d-m-Y', strtotime($task->taskStatus->updated_at)) }}</strong></label>
                            </div>
                        @endif
                    </div>
                    <div class="md:flex md:items-center mb-4">
                    <div class="md:w-1/2 mb-6 md:mb-0">
                            <label class="block text-gray-500 font-medium text-sm md:text-left mb-1 md:mb-3 pr-4"
                                for="inline-full-name">No. of Images : <strong>{{ $task->no_of_images }}</strong></label>
                        </div>
                      
                        <div class="md:w-1/2 mb-6 md:mb-0">
                            <label class="block text-gray-500 font-medium text-sm md:text-left md:mb-2 mb-3 pr-4"
                                for="inline-full-name">Image Provider : <strong>{{ $task->taskStatus ? ucwords($task->taskStatus->source) : 'N/A' }}</strong></label>
                        </div>
                  
                        <div class="w-full mb-6 md:mb-0">
                            <label class="block text-gray-500 font-medium text-sm md:text-left mb-1 md:mb-3 pr-4"
                                for="inline-full-name">Description : <strong>{{ ucfirst($task->description) }}</strong></label>
                        </div>

                    </div>
                    <div class="flex justify-between table-heading mb-3">
                            <h5 class="flex justify-start items-start font-bold text-lg text-dark-blue bg-gray-100 w-full px-2 py-2">Staff Details</h5>
                           
                    </div>
                        <hr/>
                     
                    <div class="md:flex md:items-center mb-4 mt-5">
                    @if (Auth::user()->hasRole('admin'))
                            <div class="md:w-1/2 mb-6 md:mb-0">
                                <label class="block text-gray-500 font-medium md:text-left text-sm mb-1 md:mb-3 pr-4"
                                    for="inline-full-name">Name :  <strong>{{ $task->taskStatus && $task->taskStatus->user ? $task->taskStatus->user->name : 'N/A' }}</strong></label>
                            </div>
                            <div class="md:w-1/2 mb-6 md:mb-0">
                                <label class="block text-gray-500 font-medium text-sm md:text-left mb-1 md:mb-3 pr-4"
                                    for="inline-full-name">Email :  <strong>{{ $task->taskStatus && $task->taskStatus->user ? $task->taskStatus->user->email : 'N/A' }}</strong></label>
                            </div>
                        @endif
                       
                    </div>
                </form>
               
                @if (($task->taskStatus && $task->taskStatus->user_id == Auth::user()->id) || Auth::user()->hasRole('admin'))
                    <section class="overflow-hidden">
                        <div class="container py-2 mx-auto ">
                        <h5 class="flex justify-start items-start font-bold text-lg text-dark-blue bg-gray-100 w-full px-2 py-2">Selected Images</h5>
                           
                                <hr/>
                            <div class="flex flex-wrap mt-5">

                                @forelse ($task->taskImages as $image)
                                    <div class="flex flex-wrap w-2/5 border-2 border-solid mr-3">
                                        <div class="w-full p-1 md:p-2">
                                            <img alt="gallery"
                                                class="block object-cover object-center w-full h-full rounded-lg"
                                                src="{{ $image['image_thumbnail_url'] }}">
                                        </div>
                                    </div>
                                @empty
                                    <div>No images to display</div>
                                @endforelse
                            </div>
                    </section>
                @endif
            @else
                <div class="md:flex md:items-center mb-4 mt-4">
                    <div class="md:w-1/2 mb-6 md:mb-0">
                        <label class="block text-gray-500 font-medium md:text-left text-sm mb-1 md:mb-3 pr-4"
                            for="inline-full-name">Status :  <span class="inline-flex items-center justify-center px-2 py-1 text-sm font-medium leading-none text-white bg-dark-blue rounded-full">Not started yet</span>
                       </label>
                       
                    </div>
                    <div class="md:w-1/2 mb-6 md:mb-0">
                        <label class="block text-gray-500 font-medium md:text-left text-sm mb-1 md:mb-3 pr-4">Task Name : <strong>{{ ucwords($task->name) }}</strong> </label>
                    </div>
                    <div class="md:w-1/2 mb-6 md:mb-0">
                        <label class="block text-gray-500 font-medium md:text-left text-sm mb-1 md:mb-3 pr-4">No. of images : <strong>{{ ucwords($task->no_of_images) }}</strong>
                        </label>
                    </div>
                    <div class="md:w-1/2 mb-6 md:mb-0">
                        <label class="block text-gray-500 font-medium md:text-left text-sm mb-1 md:mb-3 pr-4">Image Provider : <strong>{{ $task->taskStatus ? ucwords($task->taskStatus->source) : 'N/A' }}</strong>
                        </label>

                    </div>
                </div>
                <div class="md:flex md:items-center mb-4">

                    <div class="w-full mb-6 md:mb-0">
                        <label class="block text-gray-500 font-medium md:text-left text-sm mb-1 md:mb-3 pr-4">Description : <strong>{{ ucwords($task->description) }}</strong>
                        </label>
                    </div>

                </div>
            @endif

        </div>
    </div>
</div>
