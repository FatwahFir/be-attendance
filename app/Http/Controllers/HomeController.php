<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use App\Models\Attendance;
use App\Models\AppConfig;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $userCount = User::count();

            $locationCount = Location::count();

            $attendanceCount = Attendance::count();

            $maxRadius = AppConfig::select('max_radius')->first();

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully',
                'data' => [
                    'user_count' => $userCount,
                    'location_count' => $locationCount,
                    'attendance_count' => $attendanceCount,
                    'max_radius' => $maxRadius ? $maxRadius->max_radius : null,
                ],
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
