<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public static $perPage = 5;
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        return view('admin.home');
    }
    public function showUsers()
    {
        $users = User::with('posts')->orderBy('id', 'DESC')->paginate(static::$perPage)->withQueryString();
        return view('admin.users', [
            "users" => $users
        ]);
    }
    public function showPosts()
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
        $users = User::all();
        $categories = Category::all();
        return view('admin.posts', [
            "posts" => $posts,
            "categories" => $categories,
            "users" => $users
        ]);
    }

    public function showCategories()
    {
        $categories = Category::with('posts')->orderBy('id', 'DESC')->paginate(static::$perPage)->withQueryString();
        return view('admin.categories', [
            "categories" => $categories
        ]);
    }
}
