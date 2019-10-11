<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\File\UploadRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function upload(UploadRequest $request)
    {
        $date = date('d-m-y');
        $file = $request->file('file');
        $ext  = $file->getClientOriginalExtension();

        /* @var $client Client */
        $client = Client::with('media')->find($request->post('client_id'));
        $mediaCount =  $client->media->count();

        if ($client->firstname && $client->lastname) {
            $name = $client->firstname . ' ' . $client->lastname;
            //$this->renameDocs($client, $date);
        } else {
            $name = date('d-m-y') . '-' . str_replace('.', '-', microtime());
        }

        $file_name = $mediaCount ? $name . $mediaCount : $name;

        $path ='documents'. '/' . $date;
        $name = $file_name . '.' . $ext;
        $file->storeAs($path, $name, 'public');

        $added = $client->addMedia(storage_path('app/public/').$path.'/'.$name)->toMediaCollection('documents');

        $added->url = $added->getFullUrl();
        //dd($added);

        return response()->json([
            'media' => $added,
        ]);
    }


}
