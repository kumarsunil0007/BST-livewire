<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Staff extends Component
{
    public $staffs, $name, $email, $password, $phone, $staff_id, $header;
    public $isOpen = 0;

    public function mount()
    {
        $this->password = Hash::make(12345678);
    }
    
    public function render()
    {
        $this->staffs = User::role('staff')->orderBy('id', 'DESC')->get();
        return view('livewire.admin.staff');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->header = 'Add New Staff';
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
        $this->email = '';
        $this->phone = '';
        $this->staff_id = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email,' . $this->staff_id,
            'phone' => 'required|numeric',
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
                'password' => $this->password,
                'phone' => $this->phone
            ]);
            $staff->assignRole('staff');
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

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('success', 'Staff Deleted Successfully.');
    }
}
