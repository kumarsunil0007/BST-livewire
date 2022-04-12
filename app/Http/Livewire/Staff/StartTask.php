<?php

namespace App\Http\Livewire\Staff;

use App\Models\Setting;
use App\Models\StaffTask;
use App\Models\Task;
use App\Models\UserTaskImage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StartTask extends Component
{
    public $task_id, $keyword;
    public $show = false;
    public $images = [];
    public $queryFields = [];
    public $imageIds = [];
    public $imageStocks = [];

    public function mount($id)
    {
        $this->task_id = $id;
        $this->queryFields['sort'] = 'popular';
        $this->queryFields['orientation'] = 'horizontal';
    }

    public function render()
    {
        return view('livewire.staff.start-task');
    }

    public function searchImage()
    {
        $this->validate([
            'keyword' => 'required',
        ]);

        $this->queryFields['query'] = $this->keyword;

        $url = Setting::first();

        if ($url->source_api == 'https://www.shutterstock.com') {
            $SHUTTERSTOCK_API_TOKEN = env('SHUTTERSTOCK_API_TOKEN');

            $options = [
                CURLOPT_URL => "https://api.shutterstock.com/v2/images/search?" . http_build_query($this->queryFields),
                CURLOPT_USERAGENT => "php/curl",
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer $SHUTTERSTOCK_API_TOKEN"
                ],
                CURLOPT_RETURNTRANSFER => 1
            ];

            $handle = curl_init();
            curl_setopt_array($handle, $options);
            $response = curl_exec($handle);
            curl_close($handle);

            $decodedResponse = json_decode($response);
            $images = [];
            foreach ($decodedResponse->data as $image) {
                $images[] = [
                    'id' => $image->id,
                    'title' => $image->description,
                    'previewUrl' => $image->assets->preview->url,
                    'thumbnailUrl' => $image->assets->large_thumb->url,
                ];
            }
            $this->images = $images;
        } else {
            # code...
        }
                
    }

    public function selectImage($imageId, $imageThumbnail)
    {
        $this->imageIds['user_id'] = Auth::user()->id;
        $this->imageIds['task_id'] = $this->task_id;
        $this->imageIds['image_id'] = $imageId;
        $this->imageIds['image_thumbnail_url'] = $imageThumbnail;
        array_push($this->imageStocks, $this->imageIds);
    }

    public function removeImage($imageId)
    {
        $this->imageIds['user_id'] = Auth::user()->id;
        $this->imageIds['task_id'] = $this->task_id;
        $this->imageIds['image_id'] = $imageId;
        unset($this->imageStocks[$this->imageIds]);
    }

    public function store()
    {
        $task = Task::find($this->task_id);
        
        if (count($this->imageStocks) <= 0) {
            $this->show = true;
            session()->flash('message', 'Please select images');
            // return false;
        } else if (count($this->imageStocks) < $task->no_of_images) {
            session()->flash('message', 'Please select more images');
        } else if(count($this->imageStocks) > $task->no_of_images) {
            session()->flash('message', 'You have exceed the limit of assigned images');
        } else if (count($this->imageStocks) == $task->no_of_images) {
            UserTaskImage::insert($this->imageStocks);

            $staffTask = StaffTask::updateOrCreate(['user_id' => Auth::user()->id, 'task_id' => $this->task_id], [
                'is_completed' => 1
            ]);
            if ($staffTask) {
                session()->flash('message', 'Task completed.');
            } else {
                session()->flash('message', 'Server Error!.');
            }
        }
    }

}
