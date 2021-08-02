<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserControler extends Controller
{
    protected User $user;
    public function __construct(User $user)
    {
        $this->user = $user; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)// UserRequest $request)
    { 
        $image = $request->image->store('users');

        $url = Storage::url($image);
        dd($url);

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
