<?php

namespace App\Http\Livewire\Admin;

use App\Models\Task;
use Livewire\Component;

class Tasks extends Component
{
    public $tasks, $name, $no_of_images, $description, $task_id;
    public $isOpen = 0;

    public function render()
    {
        $this->tasks = Task::orderBy('id', 'DESC')->get();
        return view('livewire.admin.tasks');
    }

    public function create()
    {
        $this->resetInputFields();
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
        $task = Task::findOrFail($id);
        $this->task_id = $id;
        $this->name = $task->name;
        $this->no_of_images = $task->no_of_images;
        $this->description = $task->description;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Task::find($id)->delete();
        session()->flash('success', 'Task Deleted Successfully.');
    }
}
