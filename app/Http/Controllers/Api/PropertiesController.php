<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientProperty\UpdateRequest;
use App\Models\Client;
use App\Models\ClientProperty;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{

    public function index(Request $request)
    {
        return response()->json([
            'property_types' => PropertyType::all()
        ]);
    }

    public function update(UpdateRequest $request, ClientProperty $property)
    {
        $this->authorize('update', $property);

        $property->update($request->validated());

        return response()->json([
            'property' => $property
        ]);

    }


}
