<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Exception;
use App\Category;
use App\CategoryPost;
use App\Helpers\Helper;
use App\PostComment;
use App\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }
    public function showCreateForm()
    {
        $categories = Category::all();
        return view('posts.create', [
            "title" => "Create Post",
            "submitRoute" => "posts.store",
            "categories" => $categories
        ]);
    }
    public function store(Request $request)
    {
        $this->validator($request, 'store');
        // Prepare the filename and path
        $filename = time() . $request->file('image')->getClientOriginalName();
        // DB Transaction and File Save
        DB::beginTransaction();
        try {
            // Save in posts Table
            $post = new Post;
            $post->caption = $request->caption;
            $post->slug = Helper::makeSlug($request->caption);
            $post->user_id = Auth::id();
            $post->filename =  $filename;
            $post->save();
            // Save in category_posts Table
            if (isset($request->categories)) {
                $categories = Category::find($request->categories);
                $post->categories()->attach($categories);
            }
            // Upload Image
            $request->file('image')->move($this->filepath(), $filename);

            DB::commit();
            return redirect()->route('home')->with('status', 'Post created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function showEditForm($slug)
    {
        $post = Post::where('slug', $slug)->first();
        if (!$post || !Gate::allows('change-post', $post)) {
            return redirect()->back()->with('error', 'Unauthorized');
        }
        $postCategories = $post->categories;
        $postCategoryIds = [];
        foreach ($postCategories as $postCats) {
            $postCategoryIds[] = $postCats->id;
        }
        $post->categoryIds = $postCategoryIds;
        $categories = Category::all();
        return view('posts.edit', [
            "title" => "Edit Post",
            "submitRoute" => "posts.update",
            "categories" => $categories,
            "post" => $post,
        ]);
    }

    public function update(Request $request)
    {
        // Validate first for user data
        $this->validator($request, 'update');
        // Then get the post instance
        $post = Post::find($request->id);
        if (!$post || !Gate::allows('change-post', $post)) {
            return redirect()->back()->with('error', 'Unauthorized');
        }
        // If user changes image
        if (isset($request->image)) {
            $filename = time() . $request->file('image')->getClientOriginalName();
        }
        // DB Transaction and File Save
        DB::beginTransaction();
        try {
            // Save in posts Table
            $post->caption = $request->caption;
            $oldFileName = $post->filename;
            $post->filename =  isset($request->image) ? $filename : $oldFileName;
            $post->update();

            // Update in category_posts Table (first delete all and insert again, better approach?)
            if (isset($request->categories)) {
                $deleted = CategoryPost::where('post_id', $post->id)->delete();
                $categories = Category::find($request->categories);
                $post->categories()->attach($categories);
            }
            // Upload Image if it exists and delete old file
            if (isset($request->image)) {
                $request->file('image')->move($this->filepath(), $filename);
                File::exists($this->filepath() . $oldFileName) && File::delete($this->filepath() . $oldFileName);
            }
            DB::commit();
            return redirect()->route('home')->with('status', 'Post updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function showDeleteForm($slug)
    {
        $post = Post::where('slug', $slug)->first();
        if (!$post || !Gate::allows('change-post', $post)) {
            return redirect()->back()->with('error', 'Unauthorized');
        }
        return view('posts.delete', [
            "title" => "Confirm Delete Post",
            "submitRoute" => "posts.destroy",
            "post" => $post,
        ]);
    }
    public function destroy(Request $request)
    {
        $this->validator($request, 'destroy');
        $post = Post::find($request->id);
        if (!$post || !Gate::allows('change-post', $post)) {
            return redirect()->back()->with('error', 'Unauthorized');
        }
        // DB Transaction and File Save
        DB::beginTransaction();
        try {
            $post->delete();
            CategoryPost::where('post_id', $post->id)->delete();
            PostLike::where('post_id', $post->id)->delete();
            PostComment::where('post_id', $post->id)->delete();
            $deletePath = $this->filepath() . $post->filename;
            File::exists($deletePath) && File::delete($deletePath);
            DB::commit();
            return redirect()->route('home')->with('status', 'Post deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function postsByUser($user_id)
    {
        if (request()->get('category')) {
            $category = Category::where('slug', request()->get('category'))->first();
            if (!$category) abort(404);
            $posts = $category->posts()->where('user_id', $user_id)->orderBy('id', 'DESC')->paginate(HomeController::$perPage)->withQueryString();
        } else {
            $posts = Post::with('user')->where('user_id', $user_id)->orderBy('id', 'DESC')->paginate(HomeController::$perPage)->withQueryString();
        }
        return $posts;
    }

    public function showPostsByUser($slug)
    {
        $user = User::where('slug', $slug)->first();
        if (!$user) abort(404);
        $posts = $this->postsByUser($user->id);
        $categories = Category::all();
        return view(
            'home',
            [
                'posts' => $posts,
                'title' => "$user->name's Posts",
                'categories' => $categories
            ]
        );
    }


    public function validator(Request $request, $reqType = 'store')
    {
        $rules = [];
        if (isset($request->categories)) {
            $rules["categories"] = "required|array";
            $rules["categories.*"] = "integer";
        }
        if ($reqType == 'store') {
            $rules["caption"] = "required|min:1";
            $rules["image"] = "required|image";
        }
        if ($reqType == 'update') {
            $rules["caption"] = "required|min:1";
            $rules["id"] = "required|integer";
            if (isset($request->image)) {
                $rules["image"] = "required|image";
            }
        }
        if ($reqType == 'destroy') {
            $rules["id"] = "required|integer";
        }
        $request->validate($rules);
    }

    private function filepath()
    {
        return public_path('/images/posts/');
    }
}
