{{-- <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tasks
    </h2>
</x-slot> --}}
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                    role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 w-20 text-left">No.</th>
                        <th class="px-4 py-2 text-left task-name">Task Name</th>
                        <th class="px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $x = 0;
                    @endphp
                    @forelse ($my_tasks->tasks as $task)
                    @php
                        $x++;
                    @endphp
                        <tr>
                            <td class="border px-4 py-2">{{ $x }}</td>
                            <td class="border px-4 py-2 task-name">{{ $task->name }}</td>
                            <td class="border px-4 py-2">
                                @if ($task->pivot->is_completed == 1)
                                    <span>Complete</span>
                                @else
                                    <a href="{{route('staff.start.task', [$task->id])}}" class="py-2 rounded">Continue</a>
                                @endif
                                
                            </td>
                        </tr>

                    @empty
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>
