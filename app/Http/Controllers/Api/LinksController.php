<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserPostRequest;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LinksController extends Controller
{
    public function show()
    {
        return Link::all();
    }

    public function store(Request $request)
    {
        dd($request);
    }
}
