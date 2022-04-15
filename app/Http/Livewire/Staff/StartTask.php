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
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class StartTask extends Component
{
    // use WithPagination;

    public $task_id, $keyword, $multidimensional_diff, $images, $resultMessage;
    public $show = false;
    public $queryFields = [];
    public $imageIds = [];
    public $imageStocks = [];
    public $removeImageStocks = [];

    public $search;
    public $page = 1;
    public $perPage = 10;
    public $start;
    public $end;
    public $totalPage;
    public $previousBtnDisable;
    public $nextBtnDisable;
    public $result;

    public function mount($id)
    {
        $this->task_id = $id;
        $this->queryFields['orientation'] = 'horizontal';
        $this->images = [];
        $this->start = 1;
        $this->end = $this->perPage;
        if ($this->page == 1) {
            $this->previousBtnDisable = 'disabled';
        } else {
            $this->previousBtnDisable = '';
        }
        if ($this->totalPage == 1) {
            $this->nextBtnDisable = 'disabled';
        } else {
            $this->nextBtnDisable = '';
        }
    }

    public function render()
    {
        $task = Task::find($this->task_id);
        $setting = Setting::first();
        return view('livewire.staff.start-task', ['task' => $task, 'setting' => $setting]);
    }

    public function previous()
    {
        if ($this->page > 1) {
            $this->page--;
            $this->nextBtnDisable = '';
        } else {
            $this->page = 1;
        }
        if ($this->page == 1) {
            $this->previousBtnDisable = 'disabled';
        }
        $this->queryFields['page'] = $this->page;
        $this->searchImage();
    }

    public function next()
    {
        if ($this->page < $this->totalPage) {
            $this->page++;
            $this->previousBtnDisable = '';
        }
        if ($this->page == $this->totalPage) {
            $this->nextBtnDisable = 'disabled';
        }
        $this->queryFields['page'] = $this->page;
        $this->searchImage();
        
        // $this->end  = $this->end + $this->perPage;
    }

    public function searchImage()
    {
        $this->validate([
            'keyword' => 'required',
        ]);

        $setting = Setting::first();

        if ($setting->source_api == 'https://www.shutterstock.com') {
            $SHUTTERSTOCK_API_TOKEN = env('SHUTTERSTOCK_API_TOKEN');

            $this->queryFields['query'] = $this->keyword;
            $this->queryFields['sort'] = 'popular';
            $this->queryFields['per_page'] = $this->perPage;
            
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

            $decodedResponse = json_decode($response, true);
            $this->images = $decodedResponse['data'];
            $this->totalPage = ceil($decodedResponse['total_count'] / $decodedResponse['per_page']);
            
            if (!$this->images) {
                $this->resultMessage = '<div class="text-center">No result found.</div>';
            } else {
                $this->resultMessage = '';
            }
        } else if ($setting->source_api == 'https://www.storyblocks.com') {
            $privateKey = env('STORYBLOCK_PRIVATE_KEY');
            $publicKey = env('STORYBLOCK_PUBLIC_KEY');
            $projectId = env('STORYBLOCK_PROJECT_ID');
            $userId = env('STORYBLOCK_USER_ID');
            $expires = time() + 100;

            $this->queryFields['APIKEY'] = $publicKey;
            $this->queryFields['EXPIRES']
                = $expires;
            $this->queryFields['HMAC'] = $this->getToken($expires);
            $this->queryFields['project_id'] = $projectId;
            $this->queryFields['user_id'] =  $userId;
            $this->queryFields['keywords'] = $this->keyword;
            $this->queryFields['results_per_page'] = $this->perPage;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.graphicstock.com/api/v2/images/search?' . http_build_query($this->queryFields),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $decodedResponse = json_decode($response, true);

            $this->images = $decodedResponse['results'];
            $this->totalPage = ceil($decodedResponse['total_results'] / $this->perPage);
            
            $this->result = "Showing " . $this->start ." to ". $this->end ." of ". $decodedResponse['total_results']. " results" ;

            $this->start  = ($this->page * $this->perPage) + 1;
          
            if ($this->page == $this->totalPage) {
                $this->end  = $decodedResponse['total_results'];
            } else {
                $this->end  = $this->end + $this->perPage;
            }
            // dd($this->end);

            if (!$this->images) {
                $this->resultMessage = '<div class="text-center">No result found.</div>';
            } else {
                $this->resultMessage = '';
            }
        }
    }

    public function getToken($expire = null)
    {
        if (session()->has('hmac_token') && false) {
            $hmacToken = session('hmac_token');
        } else {
            $hmacToken = $this->generateToken(null, $expire);
            if ($hmacToken) {
                session('hmac_token', $hmacToken);
            }
        }
        return $hmacToken;
    }

    public function generateToken($resource = null, $expire)
    {
        $privateKey = env('STORYBLOCK_PRIVATE_KEY');
        $baseUrl = "https://api.graphicstock.com";

        if (!$resource) {
            $resource = "/api/v2/images/search";
        }

        $hmac = hash_hmac("sha256", $resource, $privateKey . $expire);
        return $hmac;
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
        $diff = array_diff(array_map('serialize', $this->imageStocks), array_map('serialize', [$this->imageIds]));
        $this->imageStocks = array_map('unserialize', $diff);
    }

    public function store()
    {
        $task = Task::find($this->task_id);
        $setting = Setting::first();

        if (count($this->imageStocks) <= 0) {
            $this->show = true;
            session()->flash('error', 'Please select images');
        } else if (count($this->imageStocks) < $task->no_of_images) {
            session()->flash('error', 'Please select more images');
        } else if (count($this->imageStocks) > $task->no_of_images) {
            session()->flash('error', 'You have exceed the limit of assigned images');
        } else if (count($this->imageStocks) == $task->no_of_images) {
            UserTaskImage::insert($this->imageStocks);

            $staffTask = StaffTask::updateOrCreate(['user_id' => Auth::user()->id, 'task_id' => $this->task_id], [
                'is_completed' => 1,
                'source' => $setting->source_name,
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
