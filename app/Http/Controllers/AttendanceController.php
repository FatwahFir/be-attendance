<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public function createAttendance(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required|exists:users,id',
                'lat' => 'required|numeric',
                'long' => 'required|numeric',
                'type' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status'=> 'success',
                    'message' => $validator->messages()->first(),
                ], 400);
            }
    
            $attendance = Attendance::create($request->all());
    
            $res = [
                'status' => 'success',
                'message' => 'success create data',
                'data' => $attendance,
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

    public function getAttendance()
    {
        $attendances = Attendance::with('user')->get();

        $res = [
            'status' => 'success',
            'message' => 'success get data',
            'data' => $attendances,
        ];

        return response()->json($res, 200);
    }
}

