<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vacancy\StoreRequest;
use App\Http\Requests\Vacancy\UpdateRequest;
use App\Models\Company;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacanciesController extends Controller
{
    public function store(StoreRequest $request)
    {
        $vacancy = Vacancy::create($request->validated());

        return response()->json([
            'vacancy' => $vacancy
        ]);
    }

    public function index(Request $request)
    {
        return response()->json([
            'vacancies' => Vacancy::orderBy('id', 'desc')->get()
        ]);
    }

    public function update(UpdateRequest $request, Vacancy $vacancy)
    {
        $vacancy->update($request->validated());

        return response()->json([
            'vacancy' => $vacancy
        ]);

    }

}
