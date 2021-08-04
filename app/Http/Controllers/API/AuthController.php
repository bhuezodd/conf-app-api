<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user; 
    }

    public function register(UserRequest $request)
    { 
        $user = $this->user->create([
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "name" => $request->name,
        ]);
        if ($user) {
            return response()->json([
                'type' => 'success',
                'message' => 'Registrado puto!'
            ]);
        }
        return response()->json([
            'message' => 'Puta la cagaste!'
        ]);
    }


    public function login(Request $request)
    {
        if ($user = $this->user->where('email',$request->email)->first()) {
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'The provided credentials are incorrect'], 401);
            }
            $user->tokens()->delete();

            $token = $user->createToken('device_name')->plainTextToken;
            return $this->respondWithToken($token);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    protected function respondWithToken($token)
    {
        return response()->json(
            [
                'token_type' => 'Bearer',
                'token' => $token,
            ]
        );
    }


}
