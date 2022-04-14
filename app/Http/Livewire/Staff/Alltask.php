<?php

namespace App\Http\Livewire\Staff;

use App\Models\Setting;
use App\Models\StaffTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Alltask extends Component
{
    use WithPagination;

    public $user_id, $task_id, $keyword;
    public $isOpen = 0;
    public $images = [];
    public $ids = [];

    public $queryFields = [];
    
    public function mount()
    {
        $this->resetPage();
        $this->queryFields['query'] = $this->keyword;
        $this->queryFields['sort'] = 'popular';
        $this->queryFields['orientation'] = 'horizontal';
    }

    public function render()
    {
        return view('livewire.staff.alltask', ['tasks' => Task::with(['taskStatus'])->orderBy('id', 'DESC')->paginate(20)]);
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function start($id)
    {
        $staffTask = StaffTask::updateOrCreate(['user_id'=>Auth::user()->id, 'task_id' => $id],[
            'is_completed' => 0,
            'source' => 'shutter stock',
        ]);
        return redirect()->route('staff.start.task', $id);
    }
}
