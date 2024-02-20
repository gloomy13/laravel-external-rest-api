<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class PetController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'headers' => ['Content-Type' => 'application/json'],
            'base_uri' => 'https://petstore.swagger.io/v2/',
            'timeout' => 5
        ]);
    }

    public function fetchPetById($id)
    {
        try {
            $response = $this->client->get('pet/' . $id);
            $result = json_decode($response->getBody());

            return $result;
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $error_message = $this->handleCommonException($e);
            return (object) ['error' => $error_message];
        }
    }

    private function handleCommonException(ClientException $e)
    {
        $statusCode = $e->getResponse()->getStatusCode();
        switch ($statusCode) {
            case 400:
                $errorMessage = 'Invalid ID supplied';
                break;
            case 404:
                $errorMessage = 'Pet not found';
                break;
            default:
                $errorMessage = 'Undocumented error';
        }
        return $errorMessage;
    }

    public function prepareFormData($formFields, $id = null)
    {
        $parsedUrls = array_filter(array_map('trim', explode(',', $formFields['photoUrls'] ?? '')));

        $parsedTags = [];
        if (!empty($formFields['tags'])) {
            $tagsSets = explode(';', $formFields['tags']);
            foreach ($tagsSets as $tagSet) {
                if (empty($tagSet)) {
                    continue;
                }
                [$tagId, $tagName] = array_map('trim', explode(',', $tagSet));
                $parsedTags[] = ['id' => $tagId, 'name' => $tagName];
            }
        }

        return [
            "id" => (int) $id,
            "category" => [
                "id" => (int) ($formFields['category']['id'] ?? 0),
                "name" => $formFields['category']['name'] ?? ""
            ],
            "name" => $formFields['name'] ?? null,
            "photoUrls" => $parsedUrls,
            "tags" => $parsedTags,
            "status" => $formFields['status']
        ];
    }

    public function show($id)
    {
        $result = $this->fetchPetById($id);

        if (isset($result->error)) {
            return view('pets.show', ['pet' => null])->with('error', $result->error);
        }

        $message = session('message', 'You found it!');

        return view('pets.show', ['pet' => $result])->with('message', $message);
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category.id' => 'nullable|numeric',
            'category.name' => 'nullable|string',
            'name' => 'nullable|string',
            'photoUrls' => 'nullable|url',
            'tags' => 'nullable|regex:/^(\d+\s*,\s*[a-zA-Z0-9]+\s*;?\s*)*$/',
            'status' => 'required|in:available,pending,sold',
        ]);

        $body = $this->prepareFormData($request->all());

        try {
            $response = $this->client->post('pet', [
                'headers' => ['accept' => 'application/json', 'Content-Type' => 'application/json'],
                'json' => $body
            ]);

            $pet = json_decode($response->getBody()->getContents());

            return redirect()->route('pets.show', ['id' => $pet->id])->with('message', 'Pet created!');
        } catch (ClientException $e) {
            if (405 == $e->getResponse()->getStatusCode()) {
                $error_message = 'Invalid input';
            } else {
                $error_message = 'Undocumented error';
            }

            return redirect()->back()->with('error', $error_message);
        }
    }

    public function edit($id)
    {
        $result = $this->fetchPetById($id);

        if (isset($result->error)) {
            return view('pets.edit', ['pet' => null])->with('error', $result->error);
        }

        $pet = $result;

        if (isset($pet->photoUrls)) {
            $pet->photoUrls = implode(", ", $pet->photoUrls);
        }

        if (isset($pet->tags)) {
            $tagsSets = array_map(function ($obj) {
                $props = get_object_vars($obj);
                return implode(', ', $props);
            }, $pet->tags);

            $tagsString = implode('; ', $tagsSets);

            $pet->tags = $tagsString;
        }

        return view('pets.edit', ['pet' => $pet]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category.id' => 'nullable|numeric',
            'category.name' => 'nullable|string',
            'name' => 'nullable|string',
            'photoUrls' => 'nullable|url',
            'tags' => 'nullable|regex:/^(\d+\s*,\s*[a-zA-Z0-9]+\s*;?\s*)*$/',
            'status' => 'required|in:available,pending,sold',
        ]);

        $body = $this->prepareFormData($request->all(), $id);

        try {
            $this->client->put('pet', [
                'headers' => ['accept' => 'application/json', 'Content-Type' => 'application/json'],
                'json' => $body
            ]);

            return redirect()->route('pets.show', ['id' => $id])->with('message', 'Pet updated!');
        } catch (ClientException $e) {
            $error_message = $this->handleCommonException($e);
            return redirect()->back()->with('error', $error_message);
        }
    }

    public function destroy($id)
    {
        try {
            $this->client->delete('pet/' . $id);
            return redirect('/')->with('message', 'Pet deleted successfully!');
        } catch (ClientException $e) {
            $error_message = $this->handleCommonException($e);
            return redirect('/')->with('error', $error_message);
        }
    }

    public function showFindPetsByStatusForm()
    {
        return view('find-pets-by-status-form');
    }

    public function findPetsByStatus(Request $request, $status)
    {
        try {
            $response = $this->client->get('pet/findByStatus', [
                'query' => ['status' => $status]
            ]);

            $results = json_decode($response->getBody());

            return view('find-pets-by-status-results', ['status' => $status, 'pets' => $results]);
        } catch (ClientException $e) {

            if (400 == $e->getResponse()->getStatusCode()) {
                $error_message = 'Invalid status value';
            } else {
                $error_message = 'Undocumented error';
            }

            return redirect()->back()->with('error', $error_message);
        }
    }

    public function showUploadImageForm($id){
        return view('pets.upload-image-form', ['id' => $id]);
    }

    public function uploadImage(Request $request, $id){
        $request->validate([
            'additionalMetadata' => 'nullable|string',
            'file' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        $petId = $id;
        $additionalMetadata = $request->additionalMetadata;
        $file = $request->file('file');

        if($file){
            $filePath = $file->getPathname();
        }

        try {
            $this->client->post("https://petstore.swagger.io/v2/pet/".$petId."/uploadImage", [
                'multipart' => [
                    [
                        'name' => 'additionalMetadata',
                        'contents' => $additionalMetadata
                    ],
                    [
                        'name' => 'file',
                        'contents' => isset($filePath) ? fopen($filePath, 'r') : null,
                        'filename' => $file ? $file->getClientOriginalName() : null,
                    ]
                ]
            ]);

            return redirect('/pets/{$id}')->with('message', 'Image uploaded successfully!');
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return redirect()->back()->with('error', 'Failed to upload image: ' . $e->getMessage());
        }
    }
}