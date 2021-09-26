<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public static $perPage = 9;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (request()->get('category')) {
            $category = Category::where('slug', request()->get('category'))->first();
            if (!$category) abort(404);
        }
        if (request()->get('user')) {
            $user = User::where('slug', request()->get('user'))->first();
            if (!$user) abort(404);
        }

        if (isset($category) && isset($user)) {
            $posts = $category->posts()->with(['likes', 'comments'])->where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(static::$perPage)->withQueryString();
        } else if (isset($category) && !isset($user)) {
            $posts = $category->posts()->with(['user', 'likes', 'comments'])->orderBy('id', 'DESC')->paginate(static::$perPage)->withQueryString();
        } else if (!isset($category) && isset($user)) {
            $posts = Post::where('user_id', $user->id)->with(['user', 'categories', 'likes', 'comments'])->orderBy('id', 'DESC')->paginate(static::$perPage)->withQueryString();
        } else {
            $posts = Post::with(['categories', 'user', 'likes', 'comments'])->orderBy('id', 'DESC')->paginate(static::$perPage)->withQueryString();
        }

        $categories = Category::all();
        $users = User::all();
        return view(
            'home',
            [
                'posts' => $posts,
                'title' => 'Home Page',
                'categories' => $categories,
                'users' => $users
            ]
        );
    }

    public function detail($slug)
    {
        $post = Post::with(['comments.user', 'likes'])->where('slug', $slug)->first();
        if (!$post) {
            return redirect()->route('home')->with('error', 'Something wrong');
        }
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = null;
        }
        return view('posts.detail', [
            "post" => $post,
            "user" => $user
        ]);
    }
}
