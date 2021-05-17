<?php

namespace App\Http\Controllers\Adminpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientVacancyController extends Controller
{
    public function index(){
        return view('adminpanel.client-vacancies.index');
    }
}
