<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !\Hash::check($request->password, $user->password)) {
            // return response()->json([
            //     'message' => 'Email/Password Tidak Sesuai(Unauthorized)'
            // ], 401);

            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('token')->plainTextToken;
        return response()->json([
            'message' => 'Success',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil Logout'
        ], 200);
    }
}
