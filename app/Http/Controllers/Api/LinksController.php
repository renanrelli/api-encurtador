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
    public function redirectLink(string $urlLink)
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
        if ($request->shortenedUrl === null) {
            $numeroAleatorio = rand(6, 8);
            $stringAleatoria = mt_rand();
            $hash = md5($stringAleatoria);
            $linkAleatorio = substr($hash, 0, $numeroAleatorio);

            $request->shortenedUrl = $linkAleatorio;
        }

        $link = Link::create([
            'shortenedUrl' => $request->shortenedUrl,
            'originalUrl' => $request->originalUrl,
            'title' => $request->title,
            'user_id' => $user->id,
        ]);
        return $link;
    }

    public function destroy(int $id)
    {
        $user = Auth::user();
        $link = Link::where('id', $id)->first();

        if (!$link) {
            return response()->json('Something gone wrong!', 404);
        }

        if ($user->id === $link->user_id) {
            $link->delete();
            return response()->noContent();
        }
        return response()->json("You don't have permission!", 403);
    }
}
