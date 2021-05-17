<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Filter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class FiltersController extends Controller
{

    public function index(Request $request)
    {
        //$this->authorize(Permission::ViewVacancies, Vacancy::class);

        $filters = Filter::where('is_hidden', 0)->with('items')->get();

        return new JsonResponse([
            'filters' => $filters
        ], 200);
    }


}
