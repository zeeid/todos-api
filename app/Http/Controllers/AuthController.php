<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        // 2. Cek jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation Error',
                'errors'  => $validator->errors() // Mengembalikan list error
            ], 422); // Status code 422 Unprocessable Entity
        }

        // 3. Jika lolos, buat user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'data'    => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // --- DEBUGGING START ---
        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            // Cek manual apakah password cocok
            $cek = Hash::check($request->password, $user->password);
            
            // Matikan program dan tampilkan hasil
            // Jika true: Password cocok (masalah di JWT)
            // Jika false: Password tidak cocok (masalah di Register/Hashing)
            // dd([
            //     'email_input' => $request->email,
            //     'password_input' => $request->password,
            //     'password_di_db' => $user->password,
            //     'apakah_cocok' => $cek ? 'YA' : 'TIDAK'
            // ]); 
        }
        // --- DEBUGGING END ---

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }

        return response()->json([
            'token' => $token
        ]);
    }

    public function me()
    {
        return response()->json(JWTAuth::user());
    }
}
