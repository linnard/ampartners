<?php

namespace App\Http\Controllers\Controlpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControlpanelController extends Controller
{
    public function index(){
        return view('controlpanel.index');
    }
}
