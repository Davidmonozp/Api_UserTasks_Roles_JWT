<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|min:3',
        'role' => 'required|string|in:admin,user',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|min:5|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    $user = User::create([
        'name' => $request->get('name'),
        'role' => $request->get('role'),
        'email' => $request->get('email'),
        'password' => bcrypt($request->get('password')),
    ]);

    $token = JWTAuth::fromUser($user);

    return response()->json([
        'message' => 'Usuario creado correctamente',
        'token' => $token
    ], 201);
}

public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|string|email',
        'password' => 'required|string|min:5',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    $credentials = $request->only(['email', 'password']);

    try {
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciales invalidas'], 401);
        }

        $user = auth('api')->user();

        $role = $user->role;
        $userId = $user->id;

        return response()->json([
            'token' => $token,
            'role' => $role,
            'userId' => $userId,
        ], 200);

    } catch (JWTException $e) {
        return response()->json(['error' => 'No se pudo crear el token, intente más tarde'], 500);
    }
}


    public function getUser() {
        $user = Auth::user();
        return response()->json([
            'user_id' => $user->id,
            'role' => $user->role,
            'email' => $user->email,
        ]);
    }

    public function logout() {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Cierre de sesión exitoso'], 200);
    }
}
