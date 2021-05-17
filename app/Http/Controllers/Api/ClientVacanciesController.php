<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientVacancy\StoreRequest;
use App\Http\Requests\ClientVacancy\UpdateRequest;
use App\Models\ClientVacancy;
use Illuminate\Http\Request;

class ClientVacanciesController extends Controller
{
    public function store(StoreRequest $request)
    {
        $this->authorize('create', ClientVacancy::class);

        $vacancy = ClietVacancy::create($request->validated());

        return response()->json([
            'vacancy' => $vacancy
        ]);
    }

    public function index(Request $request)
    {
        $vacancies = ClientVacancy::query();

        if ($request->get('is_active')){
            $vacancies->where('is_active', $request->get('is_active'));
        }

        $vacancies->orderBy('id', 'desc');

        return response()->json([
            'vacancies' => $vacancies->get()
        ]);
    }

    public function update(UpdateRequest $request, ClientVacancy $vacancy)
    {
        $this->authorize('update', $vacancy);

        $vacancy->update($request->validated());

        return response()->json([
            'vacancy' => $vacancy
        ]);

    }

}
