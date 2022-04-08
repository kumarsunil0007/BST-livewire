<?php

namespace App\Http\Livewire\Staff;

use App\Models\StaffTask;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Alltask extends Component
{
    public $tasks, $is_completed, $user_id, $staff_id, $task_id;
    public $isOpen = 0;

    public function render()
    {
        // $this->tasks = Task::with(['users'])->get();
        $this->tasks = Task::all();
        return view('livewire.staff.alltask');
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function store()
    {
            
        $staffTask = new StaffTask;
        $staffTask->user_id = Auth::user()->id;
        $staffTask->task_id = $this->task_id;
        $staffTask->save();

        session()->flash(
            'message', 'Task Started Successfully.'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

    public function start($id)
    {
        $staffTask = StaffTask::updateOrCreate(['user_id'=>Auth::user()->id, 'task_id' => $id],[
            'is_completed' => 0
        ]);
        if ($staffTask) {
            session()->flash('message', 'Task Started Successfully.');
        } else {
            session()->flash('message','Server Error!.');
        }
                
    }
}
