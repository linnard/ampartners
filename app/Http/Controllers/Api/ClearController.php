<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientProperty;
use App\Models\Company;
use App\Models\Media;
use App\Models\StatusLog;
use App\Models\User;


class ClearController extends Controller
{
    public function clear()
    {
       Client::truncate();
       ClientProperty::truncate();
       Company::truncate();
       Media::truncate();
       StatusLog::truncate();
       User::where('id', '!=', 1)->delete();
    }

}
