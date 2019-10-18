<?php

namespace App\Http\Controllers\Api;

use App\Events\Client\StatusUpdated;
use App\Http\Controllers\Controller;

use App\Http\Requests\Client\CompleteRequest;
use App\Http\Requests\Client\PatchRequest;
use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateStatusRequest;
use App\Jobs\SetClientCompleted;
use App\Models\Client\Client;
use App\Models\Client\Constants\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        $clients->load('user', 'company', 'properties', 'media', 'latest_log');

        //dd($clients->toArray());
        return response()->json([
            'clients' => $clients
        ]);
    }

    public function patch(PatchRequest $request, Client $client)
    {
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

        $client->load('user', 'company', 'properties', 'media', 'latest_log');

        return response()->json([
            'client' => $client
        ]);

    }

    public function updateStatus(UpdateStatusRequest $request, Client $client)
    {
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
                $role = User::ROLE_PARTNER;
                break;

            case Status::BOOKING_CONFIRMATION_REJECTED:
                $previous = [
                    Status::BOOKING_CONFIRMATION_EXPECTED,
                ];
                $role = User::ROLE_ADMIN;
                break;

            case Status::TICKET_EXPECTED:
                $previous = [
                    Status::BOOKING_CONFIRMATION_EXPECTED,
                ];
                $role = User::ROLE_ADMIN;
                break;

            case Status::TICKET_CONFIRMATION_EXPECTED:
                $previous = [
                    Status::TICKET_EXPECTED,
                    Status::TICKET_CONFIRMATION_REJECTED,
                ];
                $role = User::ROLE_PARTNER;
                break;

            case Status::TICKET_CONFIRMATION_REJECTED:
                $previous = [
                    Status::TICKET_CONFIRMATION_EXPECTED
                ];
                $role = User::ROLE_ADMIN;
                break;
        }


        if ($user->hasRole($role)) {
            if (in_array($current_status, $previous)) {

                $client->update($request->validated());
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
        $user = \Auth::user();

        if (!$user->hasRole('admin')) return response()->json([], 403);

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
            $clients = $user->clients()->where('id', $id)->get();
        } else {
            $clients = $user->clients()->where(function ($q) use ($s) {
                $q->where('firstname', 'LIKE', '%' . $s . '%');
                $q->orWhere('lastname', 'LIKE', '%' . $s . '%');
                $q->orWhere('note', 'LIKE', '%' . $s . '%');
            })->orWhereHas('properties', function ($q) use ($s) {
                $q->where('value', 'LIKE', '%' . $s . '%');
            })->get();
        }



        if ($clients->count()){
            $clients->load('user', 'company', 'properties', 'media', 'latest_log');
        }

        return response()->json([
            'clients' => $clients
        ]);
    }

    public function downloadZip(Client $client)
    {
        $downloads = $client->getMedia('');
        $filename = $client->firstname.' '.$client->lastname.'.zip';
        return MediaStream::create($filename)->addMedia($downloads);
    }


}
