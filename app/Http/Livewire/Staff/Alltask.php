<?php

namespace App\Http\Livewire\Staff;

use App\Models\Setting;
use App\Models\StaffTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Alltask extends Component
{
    public $tasks, $user_id, $task_id, $keyword;
    public $isOpen = 0;
    public $images = [];
    public $ids = [];

    public $queryFields = [];
    
    public function mount()
    {
        $this->queryFields['query'] = $this->keyword;
        $this->queryFields['sort'] = 'popular';
        $this->queryFields['orientation'] = 'horizontal';
    }

    public function render()
    {
        $this->tasks = Task::with(['taskStatus'])->get();
        return view('livewire.staff.alltask');
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function store()
    {
        // $staffTask = StaffTask::updateOrCreate(['user_id'=>Auth::user()->id, 'task_id' => $id],[
        //     'is_completed' => 0
        // ]);
        // if ($staffTask) {
        //     session()->flash('message', 'Task Started Successfully.');
        // } else {
        //     session()->flash('message','Server Error!.');
        // }
        // $this->closeModal();
    }

    // public function searchImage()
    // {
    //     $this->validate([
    //         'keyword' => 'required',
    //     ]);

    //     $this->queryFields['query'] = $this->keyword;

    //     $url = Setting::first();

    //     $SHUTTERSTOCK_API_TOKEN = 'v2/OEg4OVdxSzVBT01iS2ROaFNYS0hheXp5SGhXaTBCUVYvMzI3OTI5MjM2L2N1c3RvbWVyLzQvbHhUTklRd010ZGFYc1lVUm40cl85TXJvWTVob1lTcjVCYzFEbzhGdVdVWEpYcjNSc2M4S0Z1Vmh0TFZNNGExQkUzZEZweEFuV2NKdzlfbm1JWk81TmRYeVN2dEx1ZkQ0Yi04WkJTYUhsTkc4MHlvODR4QkwyTl9uVmk0N0RBdlJ3bklWUjI3TFZYY1lqWVpBd21kMGJNM2hZQXRlZjJfMjJDa2kwUnEwNkhGd0F6TGhOeXZNZGZkNzBwbVVIYjhHSm1xTUJyQ1JMeVQxbG1BSndEWlBsZy8yZG5NZlVMZmpwbXJFV3FVaXI1UEJ3';
    //     $options = [
    //         CURLOPT_URL => "https://api.shutterstock.com/v2/images/search?" . http_build_query($this->queryFields),
    //         CURLOPT_USERAGENT => "php/curl",
    //         CURLOPT_HTTPHEADER => [
    //             "Authorization: Bearer $SHUTTERSTOCK_API_TOKEN"
    //         ],
    //         CURLOPT_RETURNTRANSFER => 1
    //     ];

    //     $handle = curl_init();
    //     curl_setopt_array($handle, $options);
    //     $response = curl_exec($handle);
    //     curl_close($handle);

    //     $decodedResponse = json_decode($response);
    //     $images = [];
    //     foreach ($decodedResponse->data as $image) {
    //         $images[] = [
    //             'id' => $image->id,
    //             'title' => $image->description,
    //             'previewUrl' => $image->assets->preview->url,
    //             'thumbnailUrl' => $image->assets->large_thumb->url,
    //         ];
    //     }
    //     $this->images = $images;
        
    // }

    public function start($id)
    {
        $staffTask = StaffTask::updateOrCreate(['user_id'=>Auth::user()->id, 'task_id' => $id],[
            'is_completed' => 0
        ]);
        return redirect()->route('staff.start.task', $id);
    }
}
