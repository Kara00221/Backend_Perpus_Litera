<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:255',
            'umur' => 'required',
            'role' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'nama'=> $request->nama,
            'nomor_telepon' => $request->nomor_telepon,
            'umur' => $request->umur,
            'role' => $request->role,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
        ]);

        return response()->json([
            'user' => $user,
            'message' => 'Pustakawan berhasil didaftarkan'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) 
        {
            return response()->json(['message' => 'Invalid'] ,401);
        }

        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'detail' => $user,
            'token' => $token
        ]);
    }

    public function index()
    {
        return response()->json(User::all());
    }


    public function logout(Request $request)
    {
        if(Auth::check()) {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Log Out Berhasil']);
        }

        return response()->json(['message' => 'Belum Log In'] ,401);
    }
}
