<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index(Request $request)
    {

        $status = $request->get('status');
        $statuses = [
            User::STATUS_ENABLED,
            User::STATUS_DISABLED,
            User::STATUS_REJECTED,
        ];

        $companies = Company::with('creator');

        if ($status != null && in_array($status, $statuses)) {
            $companies = $companies->whereHas('creator', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        $companies = $companies->orderBy('id', 'desc')->get();

        //dd($companies->toArray());
        return response()->json([
            'companies' => $companies
        ]);
    }

    /*public function update(UpdateCompanyRequest $request, User $user)
    {

    }*/
}
