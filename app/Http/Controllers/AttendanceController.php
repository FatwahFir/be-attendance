<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function createAttendance(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ]);

        $attendance = Attendance::create($request->all());

        $res = [
            'status' => 'success',
            'message' => 'success create data',
            'data' => $attendance,
        ];

        return response()->json($res, 200);
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

