<?php

namespace App\Http\Livewire\Staff;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Mytask extends Component
{
    public $my_tasks;

    public function render()
    {
        $user = User::where('id', Auth::user()->id)->first();
        // $user->load('tasks');
        dd($user);
        $tasks = Task::with(['users'])->get();
        // $user = Auth::user();
        // $user->load('tasks');
        $this->my_tasks = $tasks;

        return view('livewire.staff.mytask');
    }
}
