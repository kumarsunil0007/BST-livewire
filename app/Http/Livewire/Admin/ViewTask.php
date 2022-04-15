<?php

namespace App\Http\Livewire\Admin;

use App\Models\Setting;
use App\Models\Task;
use Livewire\Component;

class ViewTask extends Component
{
    public $task_id, $task;

    public function mount($id)
    {
        $this->task_id = $id;
    }

    public function render()
    {
        $task = Task::find($this->task_id);
        $setting = Setting::first();
        $this->task = $task->load('taskImages', 'taskStatus.user');
        return view('livewire.admin.view-task', ['setting' => $setting]);
    }
}
