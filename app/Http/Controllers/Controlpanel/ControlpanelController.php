<?php

namespace App\Http\Controllers\Controlpanel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControlpanelController extends Controller
{
    public function index(){
        return view('controlpanel.index');
    }

    public function vacancies(){

        if (!Auth::check()){

            Auth::loginUsingID(2,true);
        }

        return view('controlpanel.index');
    }
}
