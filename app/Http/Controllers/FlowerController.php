<?php

namespace App\Http\Controllers;

use App\Models\Flower;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Storage;

class FlowerController extends Controller
{
    public function guzzleGet()
    {
        $client = new \GuzzleHttp\Client();
        $request = $client->get('http://testmyapi.com');
        $response = $request->getBody();
    
        dd($response);
    }
    // public function guzzlePost()
    // {
    //     $fileContent = File::get($filepath);
    //     $request = $this->client->post($url, [
    //         'multipart' => [
    //             [
    //                 'name' => 'upload',
    //                 'contents' => $fileContent,
    //                 'filename' => end(explode('/', $filepath)),
    //             ],
    //         ],
    //     ]);
    // }
    
    public function imageStore(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $image_path = $request->file('image')->store('image', 'public');

        $data = Flower::create([
            'image' => $image_path,
        ]);

        return response($data, Response::HTTP_CREATED);
    }

    public function store()
    {
        $client = new Client();
        $response = $client->request('POST', 'http://127.0.0.1:8000', [
            'multipart' => [
                [
                    'image' => 'image'
                ]
            ]
        ]);
        $response = $client->request('GET', 'http://github.com');
        echo $response->getStatusCode();
        // 200
    }
}
