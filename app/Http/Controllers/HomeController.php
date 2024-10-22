<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Location;
use App\Models\AppConfig;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $userCount = User::count();

            $locationCount = Location::count();

            $attendanceCount = Attendance::count();

            $maxRadius = AppConfig::select('max_radius')->first();

            $currentYear = Carbon::now()->year;

            $attendanceData = Attendance::select(
                    DB::raw("MONTH(created_at) as month"),
                    DB::raw("COUNT(*) as count")
                )
                ->whereYear('created_at', $currentYear)
                ->where('type', 'in')
                ->groupBy(DB::raw("MONTH(created_at)"))
                ->orderBy(DB::raw("MONTH(created_at)"))
                ->get();
            
            $attendanceByMonth = $attendanceData->map(function ($item) {
                return [
                    'x' => $item->month,
                    'y' => $item->count
                ];
            });
        

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully',
                'data' => [
                    'user_count' => $userCount,
                    'location_count' => $locationCount,
                    'attendance_count' => $attendanceCount,
                    'max_radius' => $maxRadius ? $maxRadius->max_radius : null,
                    'recap' => $attendanceByMonth,
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

