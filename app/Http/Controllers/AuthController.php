<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


 // Make sure this is here

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6'
    ], [
        'email.unique' => 'Email already exists',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'The email already exists',
            'errors' => $validator->errors()
        ], 422);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'User registered',
        'user' => $user
    ], 201);
}


    public function login(Request $request)
{
    try {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status'=>'error','message'=>'User not found'], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['status'=>'error','message'=>'Invalid password'], 401);
        }

        $token = JWTToken::generateToken($user->id);


        return response()->json([
            'status'=>'success',
            'token'=>$token
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status'=>'error',
            'message'=>'Internal server error',
            'error'=>$e->getMessage() // <- this will show the real problem
        ], 500);
    }
}

}
