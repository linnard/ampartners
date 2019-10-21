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
        $this->authorize('create', Vacancy::class);

        $vacancy = Vacancy::create($request->validated());

        return response()->json([
            'vacancy' => $vacancy
        ]);
    }

    public function index(Request $request)
    {
        $vacancies = Vacancy::query();

        if ($request->get('is_active')){
            $vacancies->where('is_active', Vacancy::STATUS_ENABLED);
        }

        $vacancies->orderBy('id', 'desc');

        return response()->json([
            'vacancies' => $vacancies->get()
        ]);
    }

    public function update(UpdateRequest $request, Vacancy $vacancy)
    {
        $this->authorize('update', $vacancy);

        $vacancy->update($request->validated());

        return response()->json([
            'vacancy' => $vacancy
        ]);

    }

}
