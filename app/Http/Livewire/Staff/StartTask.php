<?php

namespace App\Http\Livewire\Staff;

use App\Models\Setting;
use App\Models\StaffTask;
use App\Models\Task;
use App\Models\UserTaskImage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;

class StartTask extends Component
{
    use WithPagination;

    public $task_id, $keyword, $multidimensional_diff;
    public $show = false;
    public $images = [];
    public $queryFields = [];
    public $imageIds = [];
    public $imageStocks = [];
    public $removeImageStocks = [];

    public function mount($id)
    {
        $this->task_id = $id;
        $this->queryFields['sort'] = 'popular';
        $this->queryFields['orientation'] = 'horizontal';
    }

    public function render()
    {
        $task = Task::find($this->task_id);
        return view('livewire.staff.start-task', ['task' => $task]);
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
        } else if($url->source_api == 'https://www.storyblocks.com') {
            // 
        }
                
    }

    // public function paginate($items, $perPage = 5, $page = null, $options = [])
    // {
    //     $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    //     $items = $items instanceof Collection ? $items : Collection::make($items);
    //     return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    // }

    public function selectImage($imageId, $title, $preview, $thumbnail)
    {
        $this->imageIds['user_id'] = Auth::user()->id;
        $this->imageIds['task_id'] = $this->task_id;
        $this->imageIds['image_id'] = $imageId;
        $this->imageIds['image_title'] = $title;
        $this->imageIds['image_preview_url'] = $preview;
        $this->imageIds['image_thumbnail_url'] = $thumbnail;
        array_push($this->imageStocks, $this->imageIds);
        $this->imageStocks = array_map("unserialize", array_unique(array_map("serialize", $this->imageStocks)));
    }

    public function removeImage($imageId, $title, $preview, $thumbnail)
    {
        $this->imageIds['user_id'] = Auth::user()->id;
        $this->imageIds['task_id'] = $this->task_id;
        $this->imageIds['image_id'] = $imageId;
        $this->imageIds['image_title'] = $title;
        $this->imageIds['image_preview_url'] = $preview;
        $this->imageIds['image_thumbnail_url'] = $thumbnail;
        // array_push($this->removeImageStocks, $this->imageIds);
        $diff = array_diff(array_map('serialize', $this->imageStocks), array_map('serialize', [$this->imageIds]));
        $this->imageStocks = array_map('unserialize', $diff);
    }

    public function store()
    {
        $task = Task::find($this->task_id);
        
        if (count($this->imageStocks) <= 0) {
            $this->show = true;
            session()->flash('error', 'Please select images');
            // return false;
        } else if (count($this->imageStocks) < $task->no_of_images) {
            session()->flash('error', 'Please select more images');
        } else if(count($this->imageStocks) > $task->no_of_images) {
            session()->flash('error', 'You have exceed the limit of assigned images');
        } else if (count($this->imageStocks) == $task->no_of_images) {
            UserTaskImage::insert($this->imageStocks);

            $staffTask = StaffTask::updateOrCreate(['user_id' => Auth::user()->id, 'task_id' => $this->task_id], [
                'is_completed' => 1,
                'source' => 'shutter stock',
            ]);
            if ($staffTask) {
                session()->flash('success', 'Task completed.');
                return redirect()->route('staff.allTask');
            } else {
                session()->flash('error', 'Server Error!.');
            }
        }
    }

}
