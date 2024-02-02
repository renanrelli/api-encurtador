<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserPostRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function show()
    {
        return User::all();
    }
    public function store(UserPostRequest $request)
    {
        $data = $request->except('_token');
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        Auth::login($user);
        return $user;
        // $user = User::create($data);

        // Auth::login($user);

        // return response()->json($user, 201);
    }
}
