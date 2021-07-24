<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => 'required|max:55',
            'lastName' => 'required|max:55',
            'email' => 'email|required',
            'password' => 'required|confirmed'
        ]);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->access_token;

        return response(['user' => $user,'access_token' => $accessToken]);
    }
}
