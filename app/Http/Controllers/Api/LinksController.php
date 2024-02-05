<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LinkPostRequest;
use App\Http\Requests\UserPostRequest;
use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LinksController extends Controller
{
    public function testando(string $urlLink)
    {
        $link = Link::where('shortenedUrl', $urlLink)->first();
        if ($link) {
            $link->views_quantity++;
            $link->save();
            return redirect()->away($link->originalUrl);
        }
        return response()->json('Url not found', 401);
    }

    public function index()
    {
        $user = Auth::user();
        return Link::where('user_id', $user->id)->get();
    }

    public function store(LinkPostRequest $request)
    {
        $request;
        $user = Auth::user();
        $request->request->add(['user_id' => $user->id]);
        $link = Link::create([
            'shortenedUrl' => $request->shortenedUrl,
            'originalUrl' => $request->originalUrl,
            'title' => $request->title,
            'user_id' => $user->id,
        ]);
        return $link;
    }
}
