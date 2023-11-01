<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function register(Request $request) {
        //validasi
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed']
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid, contoh: jimin@example.com.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password harus diisi.',
            'password.confirmed' => 'Password tidak sama.',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors' => $validator->errors()
            ], 400);
        }

        //simpan
        $user = new user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password); //enkripsi password
        $user->save();

        return response()->json([
            'status'=> true,
            'message' => 'Register Berhasil'
        ], 201);
    }
    public function login(Request $request) {
        // Validasi
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'email'],
            'password' => ['required']
        ], [
            'username.required' => 'Username harus diinput',
            'username.email' => 'Username menggunakan format email',
            'password.required' => 'Password harus diinputkan'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }
    
        // Cek username dan password
        if (!Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            return response()->json([
                'status' => false,
                'message' => 'Username atau password salah'
            ], 400);
        }
    
        // Buat token
        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => 'Anda berhasil login',
            'token' => $token
        ], 200); 
    }
    
    public function logout() {
        Auth::user()->tokens()->delete();
        
        return response()->json([
            'status'=>true,
            'message'=>'logout berhasil'
        ],200);
    }
}
