<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\File\UploadRequest;
use App\Models\Client\Client;
use App\Models\Client\Constants\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Models\Media;

class FilesController extends Controller
{
    public function upload(UploadRequest $request)
    {
        $user = Auth::user();
        $date = date('d-m-y');
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();

        /* @var $client Client */
        $client = Client::with('media')->find($request->post('client_id'));
        $mediaCount = $client->media->count();

        if ($client->firstname && $client->lastname) {
            $name = $client->firstname . ' ' . $client->lastname;
            //$this->renameDocs($client, $date);
        } else {
            $name = date('d-m-y') . '-' . str_replace('.', '-', microtime());
        }

        $file_name = $mediaCount ? $name . $mediaCount : $name;

        if (in_array($client->status, [Status::TICKET_CONFIRMATION_REJECTED, Status::TICKET_EXPECTED])) {
            $collection = 'tickets';
            if (!$client->ticket_uploaded) {
                $client->ticket_uploaded = 1;
                $client->save();
            }
        } else {
            $collection = 'documents';
        }

        $media = $client->addMediaFromRequest('file')
            ->withCustomProperties(['user_id' => $user->id])
            ->setFileName($file_name.'.'.$ext)
            ->toMediaCollection($collection);

        return response()->json([
            'media' => $media,
        ]);
    }

    public function download(Media $file)
    {
        $user = Auth::user();
        $author_id = $file->getCustomProperty('user_id');

        if ($user->hasRole('admin') || $user->id === $author_id){
            $filename = str_replace('-', ' ', $file->file_name);
            return response()->download($file->getPath(), $filename);
        } else {
            return response()->json([], 403);
        }
    }

    public function delete(Media $file)
    {
        $user = Auth::user();
        $author_id = $file->getCustomProperty('user_id');

        if ($user->hasRole('admin') || $user->id === $author_id){
            $file->forceDelete();
            return response()->json([], 200);
        } else {
            return response()->json([], 403);
        }
    }


}
