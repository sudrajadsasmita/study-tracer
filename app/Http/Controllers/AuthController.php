<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $dataProfile = [
            "nama" => $request->nama,
            "nim" => $request->username,
            "prodi_id" => $request->prodi_id,
            "ipk" => $request->ipk,
            "tahun_masuk" => $request->tahun_masuk,
            "tahun_lulus" => $request->tahun_lulus,
        ];
        $profile = Profile::create($dataProfile);
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_id' => $profile->id
        ]);

        Auth::login($user);
        $user = JWTAuth::user();
        $userId = [
            "user_id" => $user->id
        ];
        $userData = array_merge($userId, $user->toArray(), $profile->toArray());
        $profile = Profile::findOrFail($user->profile_id);
        $userData = array_merge($user->toArray(), $profile->toArray());
        $token = JWTAuth::customClaims($userData)->fromUser($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');

        JWTAuth::attempt($credentials);
        $user = JWTAuth::user();
        $userId = [
            "user_id" => $user->id
        ];
        $profile = Profile::findOrFail($user->profile_id);
        $userData = array_merge($userId, $user->toArray(), $profile->toArray());
        $token = JWTAuth::customClaims($userData)->fromUser($user);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
}
