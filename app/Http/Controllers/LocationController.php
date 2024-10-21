<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function createLocation(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ]);

        $location = Location::create($request->all());

        $res = [
            'status' => 'success',
            'message' => 'success create data',
            'data' => $location,
        ];

        return response()->json($res, 200);
    }

    public function getLocations()
    {
        $locations = Location::all();
        $res = [
            'status' => 'success',
            'message' => 'success get data',
            'data' => $locations,
        ];

        return response()->json($res, 200);
    }
}

