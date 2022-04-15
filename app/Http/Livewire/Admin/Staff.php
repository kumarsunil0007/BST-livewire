<?php

namespace App\Http\Livewire\Admin;

use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class Staff extends Component
{
    use WithPagination;

    public $name, $email, $password, $phone, $staff_id, $header;
    public $isOpen = 0;
    public $isDelete = 0;

    public function mount()
    {
        $this->password = 12345678;
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.staff', ['staffs' => User::role('staff')->orderBy('id', 'DESC')->paginate(20)]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->header = 'Add New Staff';
        $this->openModal();
    }

    public function openModal()
    {
        $this->resetValidation();
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
        $this->email = '';
        $this->phone = '';
        $this->staff_id = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email,' . $this->staff_id,
            'phone' => 'required|integer|numeric',
        ]);
        if ($this->staff_id) {
            User::updateOrCreate(['id' => $this->staff_id], [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone
            ]);
        } else {
            $staff = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'phone' => $this->phone
            ]);
            $staff->assignRole('staff');

            try {
                Mail::to($staff->email)->send(new WelcomeEmail($staff, $this->password));
            } catch (\Exception $e) {
                // 
            }
            
        }

        session()->flash(
            'success',
            $this->staff_id ? 'Staff Updated Successfully.' : 'Staff Created Successfully.'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->header = 'Edit Staff';
        $staff = User::findOrFail($id);
        $this->staff_id = $id;
        $this->name = $staff->name;
        $this->email = $staff->email;
        $this->phone = $staff->phone;

        $this->openModal();
    }

    public function deleteId($id)
    {
        $this->deleteId = $id;
        $this->openDeleteModal();
    }

    public function delete($id)
    {
        $staff = User::find($id);
        $staff->tasks()->delete();
        $staff->delete();
        $this->closeDeleteModal();
        session()->flash('success', 'Staff Deleted Successfully.');
    }
}
