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
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Livewire\WithPagination;

class StartTask extends Component
{
    // use WithPagination;

    public $task_id, $keyword, $multidimensional_diff, $images;
    public $show = false;
    public $queryFields = [];
    public $imageIds = [];
    public $imageStocks = [];
    public $removeImageStocks = [];

    protected $privateKey;
    public $search;
    public $aicUrl = 'https://api.shutterstock.com/v2/images/';
    public $page;
    public $records;
    public $nextPageUrl;
    public $previousPageUrl;

    public function mount($id)
    {
        $this->task_id = $id;
        $this->queryFields['sort'] = 'popular';
        $this->queryFields['orientation'] = 'horizontal';
        $this->queryFields['page'] = $this->page;
        $this->queryFields['limit'] = 12;
        $this->images = [];
        $this->privateKey = env('STORYBLOCK_PRIVATE_KEY');
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
            // $images = [];
            // foreach ($decodedResponse->data as $image) {
            //     $images[] = [
            //         'id' => $image->id,
            //         'title' => $image->description,
            //         'previewUrl' => $image->assets->preview->url,
            //         'thumbnailUrl' => $image->assets->large_thumb->url,
            //     ];
            // }
            // $this->images = $images;


            $this->images = $decodedResponse->data;
            $this->previousPageUrl = Arr::get($response, 'pagination.prev_url');
            $this->nextPageUrl = Arr::get($response, 'pagination.prev_url');

        } else if ($url->source_api == 'https://www.storyblocks.com') {

            $resource = "/api/v2/videos/search";
            
            $storyBlockQuery = [
                'APIKEY' => '',
            ];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => '/api/v2/images/search?APIKEY=%3Cstring%3E&EXPIRES=%3Cstring%3E&HMAC=%3Cstring%3E&project_id=%3Cstring%3E&user_id=%3Cstring%3E&keywords=%3Cstring%3E&content_type=%3Cstring%3E&orientation=%3Cstring%3E&color=%3Cstring%3E&has_transparency=%3Cboolean%3E&has_talent_released=%3Cboolean%3E&has_property_released=%3Cboolean%3E&is_editorial=%3Cboolean%3E&categories=%3Cstring%3E&page=%3Cint%3E&results_per_page=%3Cint%3E&sort_by=%3Cstring%3E&sort_order=%3Cstring%3E&required_keywords=%3Cstring%3E&filtered_keywords=%3Cstring%3E&translate=%3Cboolean%3E&source_language=%3Cstring%3E&contributor_id=%3Cint%3E&safe_search=%3Cboolean%3E&library_ids=%3Cstring%3E&exclude_library_ids=%3Cstring%3E&content_scores=%3Cboolean%3E',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        }
    }

    public function generateToken($resource)
    {
        if (session()->has('expire')) {

            $expires = time() + 1000;
            $hmac = hash_hmac("sha256", $resource, $this->privateKey . $expires);
        }
    }

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
        } else if (count($this->imageStocks) > $task->no_of_images) {
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
