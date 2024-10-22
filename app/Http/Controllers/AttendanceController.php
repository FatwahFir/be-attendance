<?php

namespace App\Http\Controllers;

use App\Models\AppConfig;
use Carbon\Carbon;
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
                'type' => 'required|in:in,out',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status'=> 'error',
                    'message' => $validator->messages()->first(),
                ], 400);
            }
    
            $today = Carbon::now()->toDateString();
    
            $existingAttendance = Attendance::where('user_id', $request->user_id)
                                            ->whereDate('created_at', $today)
                                            ->get();
    
            $hasCheckedIn = $existingAttendance->contains('type', 'in');
            $hasCheckedOut = $existingAttendance->contains('type', 'out');
    
            if ($request->type == 'in' && $hasCheckedIn) {
                return response()->json([
                    'status'=> 'already-in',
                    'message' => 'You has already checked in today',
                ], 400);
            }
    
            if ($request->type == 'out' && $hasCheckedOut) {
                return response()->json([
                    'status'=> 'already-out',
                    'message' => 'You has already checked out today',
                ], 400);
            }
    
            $attendance = Attendance::create($request->all());
    
            $message = $request->type == 'in' ? 'Successfully checked in' : 'Successfully checked out';
    
            $res = [
                'status' => 'success',
                'message' => $message, 
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

    public function checkAttendanceStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'user_id' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'=> 'error',
                    'message' => $validator->messages()->first(),
                ], 400);
            }
            $maxRadius = AppConfig::pluck('max_radius')->first();


            $today = Carbon::now()->toDateString();

            $attendance = Attendance::where('user_id', $request->user_id)
                                    ->whereDate('created_at', $today)
                                    ->get();

            $hasCheckedIn = $attendance->contains('type', 'in');
            $hasCheckedOut = $attendance->contains('type', 'out');

            if ($hasCheckedIn && $hasCheckedOut) {
                $status = 'checked-out';
                $message = 'User has already checked out today';
            } elseif ($hasCheckedIn) {
                $status = 'checked-in';
                $message = 'User has already checked in today';
            } else {
                $status = 'not-checked-in';
                $message = 'User has not checked in today';
            }

            return response()->json([
                'status' => $status,
                'max_radius' => $maxRadius,
                'message' => $message,
            ], 200);

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

    public function getTodayAttendance($userId)
    {
        try {
            $todayAttendance = Attendance::where('user_id', $userId)
                ->whereDate('created_at', Carbon::today())
                ->get();

            if ($todayAttendance->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No attendance data for today',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Attendance data for today fetched successfully',
                'data' => $todayAttendance
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}

