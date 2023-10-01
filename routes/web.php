<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

Route::get('/setup', function () {
    $attrs = [
        'email' => 'admin@admin.com',
        'password' => 'passwod'
    ];

    if(!Auth::attempt($attrs)){
        $user = new User();

        $user->name = 'admin';
        $user->email = $attrs['email'];
        $user->password = Hash::make($attrs['password']);

        $user->save();

        if(Auth::attempt($attrs)){
            $user = Auth::user();

            // создание / генерация токенов sanctum с разнывми ролями

            $adminToken = $user->createToken('admin-token', ['create', 'update', 'delete']);
            $updateToken = $user->createToken('update-token', ['create', 'update']);
            $basicToken = $user->createToken('basic-token', ['none']); //none / basic

            return [
                'admin' => $adminToken->plainTextToken,
                'update' => $updateToken->plainTextToken,
                'basic' => $basicToken->plainTextToken,
            ];
            
        }

    }


});
