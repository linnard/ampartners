<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Client\PatchRequest;
use App\Http\Requests\Client\StoreRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function store(StoreRequest $request)
    {
        $user = \Auth::user();

        /* @var $client Client */
        $client = Client::create(array_merge($request->validated(), [
            'user_id' => $user->id,
            'company_id' => $user->companies()->first()->id
        ]));

        $client->properties()->createMany([
            [
                'value' => ''
            ],
            [
                'value' => ''
            ]
        ]);

        $client->load('user', 'company', 'properties', 'media');
        return response()->json([
            'client' => $client
        ]);
    }

    public function index(Request $request)
    {
        $clients = Client::with('user', 'company', 'properties', 'media');

        $clients = $clients->orderBy('id', 'desc')->get();

        $clients = $clients->transform(function ($item, $key) {
            foreach ($item->media as $media) {
                $media['url'] = $media->getFullUrl();
            }

            return $item;
        });

        //dd($clients);
        return response()->json([
            'clients' => $clients
        ]);
    }

    public function patch(PatchRequest $request, Client $client)
    {
        $client->update($request->validated());

        return response()->json([
            'client' => $client
        ]);

    }


}
