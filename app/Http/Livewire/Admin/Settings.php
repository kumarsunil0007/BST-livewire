<?php

namespace App\Http\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class Settings extends Component
{
    public $source_api, $selected_url, $setting;
    public $apiURLs;

    public function mount()
    {
        $this->apiURLs = [
            [
                "id" => 1,
                "url" => "https://www.shutterstock.com",
                "label" => "Shutter Stock"
            ],
            [
                "id" => 2,
                "url" =>  "https://www.storyblocks.com",
                "label" => "Story Blocks"
            ],
        ];

        $this->setting = Setting::whereId(1)->first();
        $this->selected_url = $this->setting->source_url;
        $this->source_api = $this->setting->source_url;
    }

    public function render()
    {

        return view('livewire.admin.settings', ["apiUrls" => $this->apiURLs]);
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
