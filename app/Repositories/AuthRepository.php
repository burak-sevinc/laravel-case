<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * Summary of login
     * @param array $credentials
     * @return array|null
     */
    public function login(array $credentials): array|null
    {
        $token = Auth::attempt($credentials);
        if (! $token) {
            return null;
        }

        $user = User::where('email', $credentials['email'])->first();
        $user = UserResource::make($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
