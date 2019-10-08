<?php

namespace App\Http\Controllers\Adminpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminpanelController extends Controller
{
    public function index(){
        return view('adminpanel.index');
    }
}
