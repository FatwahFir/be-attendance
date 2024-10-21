<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\AppConfig;
use Illuminate\Http\Request;

class AppConfigController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'max_radius' => 'required|integer|min:1', 
        ]);

        $config = AppConfig::updateOrCreate(
            ['id' => 1], 
            ['max_radius' => $request->max_radius]
        );

        return response()->json([
            'success' => true,
            'message'=> 'Radius maksimal diubah!',
            'data' => $config,
        ]);
    }
}
