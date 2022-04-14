<?php

namespace App\Http\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class Settings extends Component
{
    public $source_api, $selected_api, $setting;

    public function mount()
    {
        $this->setting = Setting::whereId(1)->first();
        $this->selected_api = $this->setting->source_api;
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }

    public function store()
    {
        if ($this->source_api == 'https://www.shutterstock.com') {
            $sourceName = 'shutter stock';

        } else {
            $sourceName = 'story blocks';

        }
        Setting::updateOrCreate(['id' => 1], [
            'source_name' => $sourceName,
            'source_api' => $this->source_api,
            'source_url' => $this->source_api,
        ]);

        session()->flash(
            'success',
            'Data Saved.'
        );
    }
}
