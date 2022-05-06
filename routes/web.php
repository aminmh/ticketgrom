<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('user')->group(function () {
    Route::post('/login', function (Request $request) {
        try {
            $user = User::where('username', $request->input('username'))->first();

            auth()->login($user);

            return "logged in";

        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    });
});
