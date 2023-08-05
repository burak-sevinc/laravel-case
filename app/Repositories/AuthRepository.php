<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface
{
    public function login(array $credentials)
    {
        $token = Auth::attempt($credentials);
        if (!$token) {
            return null;
        }

        $user = User::where('email', $credentials['email'])->first();
        $user = UserResource::make($user);

        $data = [
            'user' => $user,
            'token' => $token
        ];
        return $data;
    }
}
