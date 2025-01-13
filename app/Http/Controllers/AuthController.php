<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Mail\RegisterMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function me()
    {
        return response()->json(['user' => auth()->user()]);
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

    public function sendOtp(Request $request){
        $request->validate([
            'name' => 'required|string',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|unique:users',
                'password' => 'required|string|min:8|confirmed',
        ]);

        $otp = rand(100000, 999999);

        Cache::put('user_' . $request->email, [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'otp' => $otp
        ], now()->addMinutes(2));

        Mail::to($request->email)->send(new RegisterMail($request->name, $otp));

        return response()->json([
            'message' => 'OTP sent to your email, Please check the mail to verify',
            'email' => $request->email
        ]);
    }

    public function register(Request $request)
    {
        try {
            $validateData = $request->validate([
                'email' => 'required|email',
                'otp' => 'required|numeric'
            ]);

            $cached = Cache::get('user_' . $request->email);


            if(!$cached){
                return response()->json([
                    'message' => 'OTP is expired or invalid',
                ], 400);
            }

            if($cached['otp'] != $validateData['otp']){
                return response()->json([
                    'message' => 'OTP is invalid',
                ], 400);
            }

            $validateData['role_id'] = 2;

            $user = User::create($cached);

            $role = Role::findById($validateData['role_id']);
            $user->assignRole($role);

            Cache::forget('user_' . $request->email);

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

    public function sendOtpForgotPassword(Request $request)
    {
        // Validasi input email
        $request->validate([
            'email' => 'required|email|max:255|exists:users,email'
        ]);
    
        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();
    
        // Generate OTP 6 digit
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    
        // Simpan OTP di cache dengan waktu kadaluarsa 15 menit
        Cache::put('forgot_password_' . $user->email, [
            'email' => $user->email,
            'otp' => $otp
        ], now()->addMinutes(5));
    
        try {
            // Kirim OTP melalui email
            Mail::to($user->email)->send(new ForgotPasswordMail($otp));
    
            // Kembalikan respons berhasil
            return response()->json([
                'message' => 'OTP telah dikirim ke email Anda',
                'status' => true
            ], 200);
        } catch (\Exception $e) {
            // Tangani kesalahan pengiriman email
            return response()->json([
                'message' => 'Failed send OTP, Try Again',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function matchOtpForgotPassword(Request $request){
        try {
            $validate = $request->validate([
                'email' => 'required',
                'otp' => 'required',
            ]);

            $cached = Cache::get('forgot_password_' . $request->email);

            if(!$cached){
                return response()->json([
                    'message' => 'OTP is expired or invalid',
                ], 400);
            }

            if($cached['otp'] != $validate['otp']){
                return response()->json([
                    'message' => 'OTP is invalid',
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'success match otp'
            ]);
        } catch(\Exception $e){
            return response()->json([
                'message' => 'Failed Match OTP, Try Again',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateForgotPassword(Request $request){
        $validate = $request->validate([
            'password' => 'required|confirmed|min:8'
        ]);

        $user = User::where('email', $request->email)->first();

        if (Hash::check($request->password, $user->password)) {
            // Password cocok
            dd('Password matches!');
        } else {
            // Password tidak cocok
            dd('Password does not match!');
        }

        $user->update(['password' => bcrypt($validate['password'])]);

        if(!$user){
            return response()->json([
                'message' => 'Failed to update password',
                'success' => false
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'success update password'
        ]);
    }

    public function logout(){
        auth()->logout();
        return response()->json(['success' => true, 'message' => 'berhasil logout']);
    }
}
