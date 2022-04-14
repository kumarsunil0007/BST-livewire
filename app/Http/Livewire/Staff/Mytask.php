<?php

namespace App\Http\Livewire\Staff;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Mytask extends Component
{
    public $my_tasks;

    public function render()
    {
        $userTask = User::where('id', Auth::user()->id)->first();
        $userTask->load('tasks');
        
        $this->my_tasks = $userTask;

        return view('livewire.staff.mytask');
    }

}
