<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller
{
    public function show()
    {
        User::all();
    }
}
