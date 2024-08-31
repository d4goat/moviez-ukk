<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->post(), [
                'email' => 'required|email|max:255',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            if (!$token = auth()->attempt($validator->validated())) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email / Password salah!'
                ], 401);
            }

            $user = auth()->user();

            $role = $user->role;

            if ($role->id === 1) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'user' => auth()->user(),
                    'token' => $token,
                    'role' => $role
                ]);
            } elseif ($role->id === 2) { {
                    return response()->json([
                        'status' => true,
                        'message' => 'Login Berhasil',
                        'user' => auth()->user(),
                        'token' => $token,
                        'role' => $role
                    ]);
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

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
