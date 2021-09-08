<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\User;
use App\CategoryPost;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\returnSelf;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showRegisterForm()
    {
        return view('auth.register', [
            "submitRoute" => "admin.users.register"
        ]);
    }

    public function registerUser(Request $request)
    {
        $this->validator($request, $reqType = "register");
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->slug = Helper::makeSlug($request->name);
            $user->save();
            DB::commit();
            return redirect()->route('admin.users')->with('status', 'User created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function showEditForm($id)
    {
        $user = User::find($id);
        if (!$user) abort(404);
        return view('users.edit', [
            "user" => $user,
            "title" => 'Edit Users from Admin',
            "submitRoute" => 'admin.users.update',
        ]);
    }

    public function updateUser(Request $request)
    {
        $id = $request->id;
        $this->validator($request, $reqType = 'update');
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->update();
            DB::commit();
            return redirect()->route('admin.users')->with('status', 'User updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function showDeleteForm($id)
    {
        $user = User::find($id);
        if (!$user) abort(404);
        return view('users.delete', [
            "user" => $user,
            "title" => 'Delete Users from Admin',
            "submitRoute" => 'admin.users.destroy',
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate(["id" => "required|integer"]); // Only id cant validate with written function
        $user = User::find($request->id);
        if (!$user) abort(404);
        DB::beginTransaction();
        try {
            $user->delete();
            $postsToDelete = Post::where('user_id', $user->id)->get();
            if ($postsToDelete) {
                Post::where('user_id', $user->id)->delete();
                $deletedIds = [];
                foreach ($postsToDelete as $post) {
                    $deletedIds[] = $post->id;
                    $deletePath = $this->filepath() . $post->filename; // Delete Post Photos
                    File::exists($deletePath) && File::delete($deletePath);
                }
                CategoryPost::whereIn('post_id', $deletedIds)->delete(); // Where In to pass array of ids
            }
            DB::commit();
            return redirect()->route('admin.users')->with('status', 'User deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function validator(Request $request, $reqType = 'update')
    {
        $rules = ["name" => "required|string"];
        if ($reqType === 'update') {
            $rules["id"] = "required|integer";
            $rules["email"] =
                "required|email|unique:users,email,$request->id";
        }
        if ($reqType === 'register') {
            $rules['email'] = "required|string|unique:users";
        }
        if ($request->password || $reqType === 'register') {
            $rules["password"] = "required|string|min:4|max:127|confirmed";
        }
        $request->validate($rules);
    }

    private function filepath()
    {
        return public_path('/images/posts/');
    }
}
