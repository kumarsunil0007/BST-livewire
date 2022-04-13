<x-slot name="header">
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Staff
    </h2> --}}
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('success'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
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
            <div class="flex justify-end">
                <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Add Staff</button>
            </div>
            @if($isOpen)
                @include('livewire.admin.createStaff')
            @endif
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 ">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Phone</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($staffs as $staff)
                    <tr>
                        <td class="border px-4 py-2 task-name">{{ $staff->name }}</td>
                        <td class="border px-4 py-2  ">{{ $staff->email }}</td>
                        <td class="border px-4 py-2">{{ $staff->phone }}</td>
                        <td class="border px-4 py-2">
                            
                            <button wire:click="edit({{ $staff->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded" title="Edit"><i class="fa fa-edit"></i></button>
                            <button wire:click="delete({{ $staff->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" title="Delete"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>