<?php

namespace App\Http\Livewire\Staff;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Mytask extends Component
{
    use WithPagination;

    public $my_tasks;

    public function mount()
    {
        $this->resetPage();
    }

    public function render()
    {
        $userTask = User::where('id', Auth::user()->id)->first();
        $userTask->load('tasks');
        
        $this->my_tasks = $userTask;

        return view('livewire.staff.mytask');
    }

}
