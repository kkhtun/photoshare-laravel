<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', [
            "user" => $user
        ]);
    }

    public function showEditForm()
    {
        $id = Auth::id();
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('profile')->with('error', 'Something went wrong');
        }
        return view('users.edit', [
            "user" => $user,
            "title" => 'Edit Users',
            "submitRoute" => 'users.update',
        ]);
    }

    public function update(Request $request)
    {
        $id = Auth::id();
        $this->validator($request, $id);
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
            return redirect()->route('users.profile')->with('status', 'User updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function validator(Request $request, $exclude)
    {
        $rules = [
            "name" => "required|string",
            "email" =>  "required|email|unique:users,email," . $exclude,
        ];
        if ($request->password) {
            $rules["password"] = "required|string|min:4|max:127|confirmed";
        }
        $request->validate($rules);
    }
}
