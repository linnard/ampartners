<?php

namespace App\Http\Controllers\Api;

use App\Constants\User\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\Models\Media;

class FilesController extends Controller
{
    public function download(Media $file)
    {
        $this->checkPermission($file);

        $filename = str_replace('-', ' ', $file->file_name);
        return response()->download($file->getPath(), $filename);
    }

    public function delete(Media $file)
    {
        $this->checkPermission($file);

        $file->forceDelete();
        return response()->json([], 200);
    }

    private function checkPermission(Media $file){
        $user = Auth::user();
        $owner_id = $file->getCustomProperty('user_id');


        if (!$user->hasRole(Role::ADMIN) && !($user->id === $owner_id)){
            abort(403);
        };

    }




}
