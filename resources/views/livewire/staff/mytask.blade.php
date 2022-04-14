{{-- <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tasks
    </h2>
</x-slot> --}}
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('success'))
                <div class="bg-purple border-t-4 border-teal-500 rounded-b text-white px-4 py-3 shadow-md my-3"
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
                                        class="w-20 py-2 rounded bg-purple hover:bg-green-600 text-white font-bold px-4 ">Continue</a>
                                @endif
                                        <a href="{{route('staff.viewTask', [$task->id])}}" class="bg-purple hover:bg-green-600 text-white font-bold py-1 px-2 rounded" title="View"><i class="fa fa-eye" ></i></a>
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
