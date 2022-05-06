<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function notifications()
    {
        try {

            $notifications = auth()->user()->notifications();

            return response()->json(['data' => $notifications]);

        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
