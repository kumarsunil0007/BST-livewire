<?php

namespace App\Http\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class Settings extends Component
{
    public $source_api, $selected_api;

    public function mount()
    {
        $setting = Setting::whereId(1)->first();
        $this->selected_api = $setting->source_api;
    }
    
    public function render()
    {
        return view('livewire.admin.settings');
    }

    public function store()
    {
        dd($this->source_api);
        Setting::updateOrCreate(['id'=>1],['source_api' => $this->source_api]);
        
        session()->flash(
            'success',
            'Data Saved.'
        );

    }
}
