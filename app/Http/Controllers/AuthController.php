<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['registerAdmin', 'registerHospitalOwner', 'registerEmployee', 'login']]);
    }

    // Register Admin
    public function registerAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',  // Set role to 'admin'
        ]);

        return response()->json(['message' => 'Admin registered successfully', 'user' => $user], 201);
    }

    // Register Hospital Owner
    public function registerHospitalOwner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'hospital_owner',  // Set role to 'hospital_owner'
        ]);

        return response()->json(['message' => 'Hospital Owner registered successfully', 'user' => $user], 201);
    }

    // Register Employee
    public function registerEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee',  // Set role to 'employee'
        ]);

        return response()->json(['message' => 'Employee registered successfully', 'user' => $user], 201);
    }

    // Login User
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = auth()->user();  // Fetch user details
        return $this->respondWithToken($token, $user);
    }

    // Logout User
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'User successfully logged out']);
    }

    // Fetch Authenticated User
    public function me()
    {
        return response()->json(auth()->user());
    }

    // Helper function to return token with user details
    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => $user  // Include user information
        ]);
    }
}
