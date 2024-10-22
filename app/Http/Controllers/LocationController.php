<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function createLocation(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'admin_id' => 'required|exists:users,id',
                'name' => 'required|unique:locations',
                'lat' => 'required|numeric',
                'long' => 'required|numeric',
                'max_radius' => 'required|numeric',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status'=> 'success',
                    'message' => $validator->messages()->first(),
                ], 400);
            }
    
            $location = Location::create($request->all());
    
            $res = [
                'status' => 'success',
                'message' => 'success create data',
                'data' => $location,
            ];
    
            return response()->json($res, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=> 'error',
                'message' => 'Internal server error',
                'error'=>$th->getMessage(),
            ], 500);
        }
        
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

