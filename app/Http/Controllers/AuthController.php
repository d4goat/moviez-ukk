<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $validateData['role_id'] = 2;

            $user = User::create($validateData);

            $role = Role::findById($validateData['role_id']);
            $user->assignRole($role);

            // $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                // 'access_token' => $token,
                // 'token_type' => 'Bearer',
                'user' => $user
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
