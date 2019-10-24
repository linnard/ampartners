<?php

namespace App\Http\Controllers\Api;

use App\Constants\User\Role;
use App\Events\Client\StatusUpdated;
use App\Http\Controllers\Controller;

use App\Http\Requests\Client\CompleteRequest;
use App\Http\Requests\Client\PatchRequest;
use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateStatusRequest;
use App\Http\Requests\File\UploadRequest;
use App\Jobs\SetClientCompleted;
use App\Models\Client;
use App\Constants\Client\Status;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaStream;
use Spatie\MediaLibrary\Models\Media;

class ClientsController extends Controller
{
    public function store(StoreRequest $request)
    {
        $user = \Auth::user();

        $client = new Client($request->validated());

        $client->status = Status::CREATING;
        $client->user()->associate($user);
        $client->company()->associate($user->companies()->first());
        $client->save();

        $client->properties()->createMany([
            ['value' => ''],
            ['value' => '']
        ]);

        event(new StatusUpdated($client));

        $client->load('user', 'company', 'properties', 'media');

        return response()->json([
            'client' => $client
        ]);
    }

    public function index(Request $request)
    {
        $user = \Auth::user();

        $clients = $user->getVisibleClients();

        if ($request->get('statuses')){
            $clients->whereIn('status', $request->get('statuses'));
        }

        $clients = $clients->get();

        $clients->load('user', 'company', 'properties', 'media');

        //dd($clients->toArray());
        return response()->json([
            'clients' => $clients
        ]);
    }

    public function show(Client $client)
    {
        $this->authorize('control', $client);

        $client->load('user', 'company', 'properties', 'media');

        return response()->json([
            'client' => $client
        ]);
    }

    public function patch(PatchRequest $request, Client $client)
    {
        $this->authorize('update', $client);

        $client->update($request->validated());

        if ($client->wasChanged(['firstname', 'lastname'])){

            $filename = $client->firstname.' '.$client->lastname;
            $medias = $client->getMedia('');

            if ($medias->count()){
                $i = 1;

                /* @var $media Media */
                foreach ($medias as $media){
                    $extension = pathinfo($media->getPath(), PATHINFO_EXTENSION);
                    $media->name = $filename.$i;
                    $media->file_name = $filename.$i.'.'.$extension;
                    $media->save();
                    $i++;
                }
            }
        }

        $client->load('user', 'company', 'properties', 'media');

        return response()->json([
            'client' => $client
        ]);

    }

    public function updateStatus(UpdateStatusRequest $request, Client $client)
    {
        $this->authorize('updateStatus', $client);

        $status = $request->input('status');
        $comment = $request->input('comment');
        $current_status = $client->status;
        $user = \Auth::user();

        switch ($status) {
            case Status::BOOKING_CONFIRMATION_EXPECTED:
                $previous = [
                    Status::CREATING,
                    Status::BOOKING_CONFIRMATION_REJECTED
                ];
                $role = Role::PARTNER;
                break;

            case Status::BOOKING_CONFIRMATION_REJECTED:
                $previous = [
                    Status::BOOKING_CONFIRMATION_EXPECTED,
                ];
                $role = Role::ADMIN;
                break;

            case Status::TICKET_EXPECTED:
                $previous = [
                    Status::BOOKING_CONFIRMATION_EXPECTED,
                ];
                $role = Role::ADMIN;
                break;

            case Status::TICKET_CONFIRMATION_EXPECTED:
                $previous = [
                    Status::TICKET_EXPECTED,
                    Status::TICKET_CONFIRMATION_REJECTED,
                ];
                $role = Role::PARTNER;
                break;

            case Status::TICKET_CONFIRMATION_REJECTED:
                $previous = [
                    Status::TICKET_CONFIRMATION_EXPECTED
                ];
                $role = Role::ADMIN;
                break;
        }


        if ($user->hasRole($role)) {
            if (in_array($current_status, $previous)) {

                $client->update(array_merge($request->validated(), [
                    'is_updated' => 1
                ]));

                event(new StatusUpdated($client, $comment));

                return response()->json([
                    'client' => $client
                ]);

            } else {
                return response()->json([], 422);
            }
        } else {
            return response()->json([], 403);
        }

    }

    public function complete(CompleteRequest $request, Client $client)
    {
        $this->authorize('complete', $client);

        $comment = $request->input('comment');

        $complete_at = Carbon::parse($request->input('complete_at'));

        if ($complete_at < Carbon::now()) {
            return response()->json([
                'message' => 'Не можна вказувати час та дату, які вже минули!'
            ], 422);
        }

        $client->complete_at = $complete_at;
        $client->save();

        dispatch(new SetClientCompleted($client, $comment))->delay($complete_at);

        return response()->json([
            'message' => 'Успішно завершений! Зміни вступлять в дію ' . $complete_at
        ], 200);
    }

    public function search(Request $request)
    {
        $user = \Auth::user();
        $s = $request->input('query');

        if (strpos($s, 'ID') !== false) {
            $id = preg_replace("/[^0-9]/", "", $s);
            $clients = $user->getVisibleClients()->where('id', $id)->get();
        } else {
            $clients = $user->getVisibleClients()->where(function ($q) use ($s) {
                $q->where('firstname', 'LIKE', '%' . $s . '%');
                $q->orWhere('lastname', 'LIKE', '%' . $s . '%');
                $q->orWhere('note', 'LIKE', '%' . $s . '%');
                $q->orWhereHas('properties', function ($q) use ($s) {
                    $q->where('value', 'LIKE', '%' . $s . '%');
                });
            })->get();
        }

        if ($clients->count()){
            $clients->load('user', 'company', 'properties', 'media');
        }

        return response()->json([
            'clients' => $clients
        ]);
    }

    public function downloadZip(Client $client)
    {
        $this->authorize('downloadZip', $client);

        $downloads = $client->getMedia('');
        $filename = $client->firstname.' '.$client->lastname.'.zip';
        return MediaStream::create($filename)->addMedia($downloads);
    }

    public function upload(UploadRequest $request, Client $client)
    {
        $this->authorize('uploadDocs', $client);

        $user = Auth::user();
        $file = $request->file('file');
        $ext  = $file->getClientOriginalExtension();
        $collection = 'documents';
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
        }

        $media = $client->addMediaFromRequest('file')
            ->withCustomProperties(['user_id' => $user->id])
            ->setFileName($file_name.'.'.$ext)
            ->toMediaCollection($collection);

        return response()->json([
            'media' => $media,
        ]);
    }
}
