<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::with('userDetails')->get();
        $res = [
            'status' => 'success',
            'message' => 'success get data',
            'data' => $users,
        ];

        return response()->json($res, 200);
    }
}

