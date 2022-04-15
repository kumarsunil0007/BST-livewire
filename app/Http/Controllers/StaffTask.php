<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffTask extends Controller
{
    
    public function searchImage($keyword)
    {
        $queryFields = [
            "query" => $keyword,
            "sort" => "popular",
            "orientation" => "horizontal"
        ];
        $SHUTTERSTOCK_API_TOKEN = 'v2/OEg4OVdxSzVBT01iS2ROaFNYS0hheXp5SGhXaTBCUVYvMzI3OTI5MjM2L2N1c3RvbWVyLzQvbHhUTklRd010ZGFYc1lVUm40cl85TXJvWTVob1lTcjVCYzFEbzhGdVdVWEpYcjNSc2M4S0Z1Vmh0TFZNNGExQkUzZEZweEFuV2NKdzlfbm1JWk81TmRYeVN2dEx1ZkQ0Yi04WkJTYUhsTkc4MHlvODR4QkwyTl9uVmk0N0RBdlJ3bklWUjI3TFZYY1lqWVpBd21kMGJNM2hZQXRlZjJfMjJDa2kwUnEwNkhGd0F6TGhOeXZNZGZkNzBwbVVIYjhHSm1xTUJyQ1JMeVQxbG1BSndEWlBsZy8yZG5NZlVMZmpwbXJFV3FVaXI1UEJ3';
        $options = [
            CURLOPT_URL => "https://api.shutterstock.com/v2/images/search?" . http_build_query($queryFields),
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

        $response = [
            'success' =>  true,
            'data' => $images
        ];

        return response()->json($response, 200);
    }
}
