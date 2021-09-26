<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Category;
use App\PostLike;
use App\PostComment;
use App\CategoryPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function showEditForm($id)
    {
        $post = Post::find($id);
        if (!$post) abort(404);
        $postCategories = $post->categories;
        $postCategoryIds = [];
        foreach ($postCategories as $postCats) {
            $postCategoryIds[] = $postCats->id;
        }
        $post->categoryIds = $postCategoryIds;
        $categories = Category::all();
        return view('posts.edit', [
            "title" => "Edit Post from Admin",
            "submitRoute" => "admin.posts.update",
            "categories" => $categories,
            "post" => $post,
        ]);
    }

    public function updatePost(Request $request)
    {
        // Validate first for user data
        $this->validator($request, 'update');
        // Then get the post instance
        $post = Post::find($request->id);
        if (!$post) abort(404);
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
            return redirect()->route('admin.posts')->with('status', 'Post updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function showDeleteForm($id)
    {
        $post = Post::find($id);
        if (!$post) abort(404);
        return view('posts.delete', [
            "title" => "Confirm Delete Post from Admin",
            "submitRoute" => "admin.posts.destroy",
            "post" => $post,
        ]);
    }

    public function destroy(Request $request)
    {
        $this->validator($request, 'destroy');
        $post = Post::find($request->id);
        if (!$post) abort(404);
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
            return redirect()->route('admin.posts')->with('status', 'Post deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function validator(Request $request, $reqType = 'update')
    {
        $rules = [];
        if (isset($request->categories)) {
            $rules["categories"] = "required|array";
            $rules["categories.*"] = "integer";
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
