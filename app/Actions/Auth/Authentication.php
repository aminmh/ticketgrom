<?php

namespace App\Actions\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\UnauthorizedException;

class Authentication
{

    public function __construct(protected Request $request)
    {
    }

    public function signin()
    {
        $credentials = $this->request->only(['username', 'password']);

        $remember = $this->request->boolean('rememberMe', false);

        if (Auth::attempt($credentials, $remember))
            return Auth::user();

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
        Auth::logout();

        Session::flush();
    }
}
