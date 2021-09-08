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
            $posts = $category->posts()->with(['user', 'likes', 'comments'])->orderBy('id', 'DESC')->paginate(static::$perPage)->withQueryString();
        } else {
            $posts = Post::with(['categories', 'user', 'likes', 'comments'])->orderBy('id', 'DESC')->paginate(static::$perPage)->withQueryString();
        }
        $categories = Category::all();
        return view('admin.posts', [
            "posts" => $posts,
            "categories" => $categories
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
