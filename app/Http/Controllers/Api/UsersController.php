<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserPostRequest;
use App\Models\LinkStats;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

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
        if ($user) {
            Auth::login($user);

            LinkStats::create([
                'user_id' => $user->id
            ]);
            return response()->json($user, 201);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json('Incorrect email and / or password', 401);
        }

        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('token');

        return response()->json($token->plainTextToken, 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
