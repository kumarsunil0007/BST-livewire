{{-- <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tasks
    </h2>
</x-slot> --}}
<div class="py-3 px-5 text-gray-700 bg-dark-blue" aria-label="Breadcrumb">
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
            </ol>
     </div>
</nav>
    <div class="container mx-auto py-12">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('success'))
                <div class="bg-dark-blue border-t-4 border-teal-500 rounded-b text-white px-4 py-3 shadow-md my-3"
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
            <div class="flex justify-between table-heading my-3">
                <h4 class="flex justify-center items-center font-bold">My Tasks</h4>

            </div>
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 text-left">Task Name</th>
                        <th class="px-4 py-2">No. of images</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($my_tasks->tasks as $task)
                        <tr>
                            <td class="border px-4 py-2 task-name">{{ $task->name }}</td>
                            <td class="border px-4 py-2">{{ $task->no_of_images }}</td>
                            <td class="border px-4 py-2">{{ Str::limit($task->description, 50, '...') }}</td>
                            <td class="border px-4 py-2">
                                @if ($task->pivot->is_completed == 1)
                                    <span
                                        class="w-20 py-2 rounded bg-gray-500 hover:bg-green-600 text-white font-bold px-4 ">Completed</span>
                                @else
                                    <a href="{{ route('staff.start.task', [$task->id]) }}"
                                        class="w-20 py-2 rounded bg-dark-blue hover:bg-green-600 text-white font-bold px-4 ">Continue</a>
                                @endif
                                        <a href="{{route('staff.viewTask', [$task->id])}}" class="bg-dark-blue hover:bg-green-600 text-white font-bold py-1 px-2 rounded" title="View"><i class="fa fa-eye" ></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">
                                <div>No result found.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
