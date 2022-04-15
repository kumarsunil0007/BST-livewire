<x-slot name="header">
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Staff
    </h2> --}}
</x-slot>
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
                        <div class="ml-1 text-sm font-medium text-white">Task</div>
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
            <div class="flex justify-between table-heading">
                <h5 class="flex justify-center items-center text-lg font-bold text-gray-700">All Tasks</h5>
                <button wire:click="create()"
                    class="bg-dark-blue hover:bg-dark-blue text-white py-2 px-4 rounded my-3">Add Task</button>
            </div>
            @if ($isOpen)
                @include('livewire.admin.create')
            @endif
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 font-medium text-sm">Task Name</th>
                        <th class="px-4 py-2 font-medium text-sm">No. of images</th>
                        <th class="px-4 py-2 font-medium text-sm">Description</th>
                        <th class="px-4 py-2 font-medium text-sm">Status</th>
                        <th class="px-4 py-2 font-medium text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                        <tr>
                            <td class="border px-4 py-2 task-name text-gray-500 text-sm">{{ $task->name }}</td>
                            <td class="border px-4 py-2 text-gray-500 text-sm">{{ $task->no_of_images }}</td>
                            <td class="border px-4 py-2 text-gray-500 text-sm">
                                {{ Str::limit($task->description, 150, '...') }}</td>
                            <td class="border px-4 py-2 text-gray-500 text-sm">
                                {{ $task->taskStatus ? ($task->taskStatus->is_completed == 0 ? 'In progress' : 'Completed') : 'No started yet' }}
                            </td>
                            <td class="border px-4 py-2 text-gray-500 text-sm">
                                <a href="{{ route('admin.viewTask', [$task->id]) }}"
                                    class="bg-dark-blue hover:bg-blue-700 text-white font-bold py-1 px-2 rounded"
                                    title="View"><i class="fa fa-eye"></i></a>
                                @if (!isset($task->taskStatus))
                                    <button wire:click="edit({{ $task->id }})"
                                    class="bg-dark-blue hover:bg-blue-700 text-white font-bold py-1 px-2 rounded"
                                    title="Edit"><i class="fa fa-edit"></i></button>
                                @elseif(isset($task->taskStatus) && $task->taskStatus->is_completed == 0)
                                <button wire:click="edit({{ $task->id }})"
                                    class="bg-dark-blue hover:bg-blue-700 text-white font-bold py-1 px-2 rounded"
                                    title="Edit"><i class="fa fa-edit"></i></button>
                                @endif
                                
                                <button wire:click="deleteId({{ $task->id }})"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
                                    title="Delete"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="5"><div class="border px-4 py-2 task-name text-gray-500 text-sm">No result found</div></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="my-4">{{ $tasks->links() }}</div>
            @if ($isDelete)
                <div wire:ignore.self
                    class="min-w-screen h-screen animated fadeIn faster fixed  left-0 top-0 flex justify-center items-center inset-0 z-50 outline-none focus:outline-none bg-no-repeat bg-center bg-cover"
                    id="modal-id">
                    <div class="absolute bg-black opacity-80 inset-0 z-0"></div>
                    <div class="w-full  max-w-lg p-5 relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">
                        <!--content-->
                        <div class="">
                            <!--body-->
                            <div class="text-center p-5 flex-auto justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4 -m-1 flex items-center text-red-500 mx-auto" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-16 h-16 flex items-center text-red-500 mx-auto" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <h2 class="text-xl font-bold py-4 ">Are you sure?</h3>
                                    <p class="text-sm text-gray-500 px-8">Do you really want to delete this task?
                                        This process cannot be undone</p>
                            </div>
                            <!--footer-->
                            <div class="p-3  mt-2 text-center space-x-4 md:block">
                                <button wire:click="closeDeleteModal()"
                                    class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">
                                    Cancel
                                </button>
                                <button wire:click.prevent="delete({{ $deleteId }})"
                                    class="mb-2 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
