<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserDetailController extends Controller
{
    public function setUserLocation(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required|exists:user_details,user_id',
                'location_id' => 'required|exists:locations,id',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status'=> 'success',
                    'message' => $validator->messages()->first(),
                ], 400);
            }
    
            $userDetail = UserDetail::where('user_id', $request->user_id)->first();
    
            if ($userDetail) {
                $userDetail->location_id = $request->location_id;
                $userDetail->save();
    
                return response()->json([
                    'status' => 'success',
                    'message' => 'User location updated successfully.',
                    'data' => $userDetail
                ]);
            } else {
                return response()->json(['message' => 'User not found.'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status'=> 'error',
                'message' => 'Internal server error',
                'error'=>$th->getMessage(),
            ], 500);
        }
        
    }
}

