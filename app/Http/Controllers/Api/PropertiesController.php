<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    public function update(Request $request, ClientProperty $property)
    {
        $property->update([
            'type_id' => $request->input('type_id'),
            'value' => $request->input('value')
        ]);

        return response()->json([
            'vacancy' => $property
        ]);

    }


}
