<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * function getMyUserName
     *
     * @param Request $request
     * @return
     */
    public function getMyUserName(Request $request)
    {
        $request->validate([
            'apikey' => 'required|string',
        ]);

        $userData = User::where('api_key', $request->input('apikey'))
            ->select([
                'username',
                'country',
                'phone',
                'api_key',
            ])
            ->first();

        if (!$userData) {
            return response()->json([
                'message' => 'User not found. Sorry!'
            ], 404);
        }

        return response()->json($userData);
    }
}
