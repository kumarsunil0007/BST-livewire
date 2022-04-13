<?php

namespace App\Http\Livewire\Admin;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class Tasks extends Component
{
    use WithPagination;

    public $name, $no_of_images, $description, $task_id, $deleteId, $header;
    public $isOpen = 0;
    public $isDelete = 0;

    public function mount()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.tasks', ['tasks' => Task::orderBy('id', 'DESC')->paginate(20)]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->header = 'Create New Task';
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }
    
    public function openDeleteModal()
    {
        $this->isDelete = true;
    }

    public function closeDeleteModal()
    {
        $this->isDelete = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->no_of_images = '';
        $this->description = '';
        $this->task_id = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $this->validate([
            'name' => 'required',
            'no_of_images' => 'required',
            'description' => 'required',
        ]);
        if ($this->task_id) {
            Task::updateOrCreate(['id' => $this->task_id], [
                'name' => $this->name,
                'no_of_images' => $this->no_of_images,
                'description' => $this->description
            ]);
        } else {
            Task::create([
                'name' => $this->name,
                'no_of_images' => $this->no_of_images,
                'description' => $this->description
            ]);
        }

        session()->flash(
            'success',
            $this->task_id ? 'Task Updated Successfully.' : 'Task Created Successfully.'
        );

        $this->closeModal();
        $this->resetInputFields();
    }



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $this->header = 'Edit Task';
        $task = Task::findOrFail($id);
        $this->task_id = $id;
        $this->name = $task->name;
        $this->no_of_images = $task->no_of_images;
        $this->description = $task->description;

        $this->openModal();
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
        $this->openDeleteModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Task::find($id)->delete();
        $this->closeDeleteModal();
        session()->flash('success', 'Task Deleted Successfully.');
    }
}
