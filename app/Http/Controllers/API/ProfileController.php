<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user; 
    }

    public function show() 
    {
        return new UserResource(Auth::user());
    }

    public function update(ProfileRequest $request) 
    {
        $id = Auth::user()->id;
        $attibutes = [
            "name" => $request->name,
            "email" => $request->email,
        ];
        
        $user = $this->user->find($id);

        if ($request->has('image')) {
            if ($user->image) {
                Storage::delete($user->image);
            }    
           $image = $request->image->store('users');
            // $url = Storage::url($image);
            $attibutes["image"] = $image;
        }

        if ($user->update($attibutes)) {
            return new UserResource($user); 
        }
        return response()->json([
            "message" => "error al actualizar"
        ]);

    }

    public function updatePassword(PasswordRequest $request)
    {
        $id = Auth::user()->id;

        $user = $this->user->find($id);

        if ($user->update([
            'password' => Hash::make($request->password)
        ])) {
            return new UserResource($user); 
        }
        return response()->json([
            "message" => "error al actualizar"
        ]);
    }
}
