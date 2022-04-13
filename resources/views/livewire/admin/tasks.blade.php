<x-slot name="header">
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tasks
    </h2> --}}
</x-slot>
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
            <div class="flex justify-between table-heading">
                <h4 class="flex justify-center items-center font-bold">All Tasks</h4>
                <button wire:click="create()"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Add Task</button>
            </div>
            @if ($isOpen)
                @include('livewire.admin.create')
            @endif
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 ">Task Name</th>
                        <th class="px-4 py-2">No of images</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td class="border px-4 py-2 task-name">{{ $task->name }}</td>
                            <td class="border px-4 py-2">{{ $task->no_of_images }}</td>
                            <td class="border px-4 py-2">{{ Str::limit($task->description, 150, '...') }}</td>
                            <td class="border px-4 py-2">{{ ($task->taskStatus ? ($task->taskStatus->is_completed == 0 ? 'In progress' : 'Completed') : 'No started yet') }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{route('admin.viewTask', [$task->id])}}" class="bg-purple hover:bg-green-600 text-white font-bold py-1 px-2 rounded" title="View"><i class="fa fa-eye" ></i></a>
                            <button wire:click="edit({{ $task->id }})" class="bg-purple hover:bg-blue-700 text-white font-bold py-1 px-2 rounded" title="Edit"><i class="fa fa-edit" ></i></button>
                            <button wire:click="deleteId({{ $task->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" title="Delete"><i class="fa fa-trash" ></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="my-4">{{ $tasks->links() }}</div>
            
            @if ($isDelete)
            <div wire:ignore.self class="min-w-screen h-screen animated fadeIn faster fixed  left-0 top-0 flex justify-center items-center inset-0 z-50 outline-none focus:outline-none bg-no-repeat bg-center bg-cover" id="modal-id">
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
                            <button wire:click.prevent="delete({{$deleteId}})"
                                class="mb-2 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
