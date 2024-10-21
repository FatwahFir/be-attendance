<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use App\Models\Location;
use Illuminate\Http\Request;

class UserDetailController extends Controller
{
    public function setUserLocation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:user_details,user_id',
            'location_id' => 'required|exists:locations,id',
        ]);

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
    }
}

