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
                        <div class="ml-1 text-sm font-medium text-white">Tasks</div>
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
            @if ($isOpen)
                @include('livewire.staff.start')
            @endif
            <div class="flex justify-between table-heading my-3">
                <h5 class="flex justify-center items-center text-lg font-bold text-gray-700">All Tasks</h5>
            </div>
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 font-medium text-sm text-left task-name w-60">Task Name</th>
                        <th class="px-4 py-2 font-medium text-sm">Description</th>
                        <th class="px-4 py-2 font-medium text-sm w-48">No. of images</th>
                        <th class="px-4 py-2 font-medium text-sm w-48">Status</th>
                        <th class="px-4 py-2 font-medium text-sm text-left w-48">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                        <tr>
                            <td class="border px-4 py-2 truncate text-gray-500 text-sm flex-1">
                                {{ ucwords($task->name) }}</td>
                            <td class="border px-4 py-2 truncate text-gray-500 text-sm">
                                {{ Str::limit($task->description, 150, '...') }}</td>
                            <td class="border px-4 py-2 text-gray-500 text-sm">{{ $task->no_of_images }}</td>
                            <td class="border px-4 py-2 text-gray-500 text-sm">
                                {{ $task->taskStatus ? ($task->taskStatus->is_completed == 0 ? 'In progress' : 'Completed') : 'No started yet' }}
                            </td>
                            <td class="border px-4 py-2 text-gray-500 text-sm">
                                <a href="{{ route('staff.viewTask', [$task->id]) }}"
                                    class="bg-dark-blue hover:bg-blue-700 text-white font-bold py-1 px-2 rounded"
                                    title="View"><i class="fa fa-eye"></i></a>
                                @if (!$task->taskStatus)
                                    <button wire:click="start({{ $task->id }})"
                                        class="bg-green-600 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded"
                                        style="line-height:17px"
                                        {{ Auth::user()->currentTask() ? 'disabled' : '' }}>Start
                                    </button>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="border px-4 py-2 task-name text-gray-500 text-sm">No result found</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="my-4">{{ $tasks->links() }}</div>
        </div>
    </div>
</div>
