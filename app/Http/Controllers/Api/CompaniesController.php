<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\IndexRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index(IndexRequest $request)
    {

        $user   = \Auth::user();

        /* @var $companies Company */
        $companies = $user->getVisibleCompanies();

        if ($request->has('status')) {
            $status = $request->get('status');
            $companies = $companies->whereHas('creator', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        $companies = $companies->orderBy('id', 'desc')->get();
        $companies->load('creator');

        //dd($companies->toArray());

        return response()->json([
            'companies' => $companies
        ]);
    }

}
