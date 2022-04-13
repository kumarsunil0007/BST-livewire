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
            {{-- <button wire:click="start()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3 mr-auto">Create New Task</button> --}}
            @if ($isOpen)
                @include('livewire.staff.start')
            @endif
            <div class="flex justify-between table-heading my-3">
                <h4 class="flex justify-center items-center font-bold">All Tasks</h4>
            </div>
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 text-left task-name">Task Name</th>
                        <th class="px-4 py-2">No of images</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td class="border px-4 py-2 flex-1">{{ ucwords($task->name) }}</td>
                            <td class="border px-4 py-2">{{ $task->no_of_images }}</td>
                            <td class="border px-4 py-2">{{ Str::limit($task->description, 50, '...') }}</td>
                            <td class="border px-4 py-2">
                                @if ($task->taskStatus)
                                    @if ($task->taskStatus->task_id == $task->id && $task->taskStatus->user_id == Auth::user()->id && $task->taskStatus->is_completed == 0)
                                        <button
                                            class="bg-gray-400 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                                            disabled>In progress</button>
                                    @elseif($task->taskStatus->task_id == $task->id && $task->taskStatus->user_id == Auth::user()->id && $task->taskStatus->is_completed == 1)
                                        <button
                                            class="bg-gray-400 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                                            disabled>Completed</button>
                                    @else
                                        <button
                                            class="bg-gray-400 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                                            disabled>Completed</button>
                                    @endif
                                @else
                                    <button wire:click="start({{ $task->id }})"
                                        class="bg-green-600 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Start
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="my-4">{{ $tasks->links() }}</div>
        </div>
    </div>
</div>
