<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class Authentication
{

    public function __construct(protected Request $request)
    {
    }

    public function signin(bool $remember = false)
    {
        $credentials = $this->request->only(['username', 'password']);

        if (Auth::attempt($credentials, $remember))
            return $this->doAfterAuthenticate();

        throw new UnauthorizedException(__('messages.INCORRECT_CREDENTILAS', [], 'fa'), 422);
    }

    public function token(string $tokenName)
    {
        if ($user = $this->request->user())

            return $user->createToken($tokenName)->plainTextToken;

        throw new UnauthorizedException(__('messages.UNAUTHENTICATED', [], 'fa'), 401);
    }

    public function signout()
    {
    }

    public function doAfterAuthenticate(): void
    {
    }
}
