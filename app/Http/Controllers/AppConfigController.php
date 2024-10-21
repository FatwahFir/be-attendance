<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\AppConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppConfigController extends Controller
{
    public function update(Request $request)
    {

        try {
            $validator = Validator::make($request->all(),[
                'max_radius' => 'required|integer|min:1', 
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status'=> 'success',
                    'message' => $validator->messages()->first(),
                ], 400);
            }
    
            $config = AppConfig::updateOrCreate(
                ['id' => 1], 
                ['max_radius' => $request->max_radius]
            );
    
            return response()->json([
                'success' => true,
                'message'=> 'Radius maksimal diubah!',
                'data' => $config,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=> 'error',
                'message' => 'Internal server error',
                'error'=>$th->getMessage(),
            ], 500);
        }
    }
}
