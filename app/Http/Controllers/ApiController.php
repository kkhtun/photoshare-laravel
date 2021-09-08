<?php

namespace App\Http\Controllers;

use App\PostComment;
use App\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    //
    public function likePost(Request $request)
    {
        $validation = $this->validator($request, 'like');
        if ($validation == false || Auth::id() != $request->userid) {
            return response()->json([
                "status" => "something went wrong"
            ], 401);
        }
        $status = "";
        DB::beginTransaction();
        try {
            $alreadyLiked = PostLike::where('post_id', $request->postid)->where('user_id', $request->userid)->first();
            if (!$alreadyLiked) {
                $postLike = new PostLike();
                $postLike->user_id = $request->userid;
                $postLike->post_id = $request->postid;
                $postLike->save();
                $status = "liked";
            } else {
                $alreadyLiked->delete();
                $status = "unliked";
            }
            $count = DB::table('post_likes')->where('post_id', $request->postid)->count();
            DB::commit();
            return response()->json([
                "status" => $status,
                "count" => $count
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => "Something went wrong"
            ], 500);
        }
    }

    public function commentPost(Request $request)
    {
        $validation = $this->validator($request, 'comment');
        if ($validation == false || Auth::id() != $request->userid) {
            return response()->json([
                "status" => "Invalid Comment"
            ], 401);
        }
        DB::beginTransaction();
        try {
            $postComment = new PostComment();
            $postComment->user_id = $request->userid;
            $postComment->post_id = $request->postid;
            $postComment->comment = $request->comment;
            $postComment->save();
            $comment = PostComment::find($postComment->id);
            $comment->username = $comment->user->name;
            $comment->diffForHumans = $comment->created_at->diffForHumans();
            DB::commit();
            return response()->json([
                "status" => true,
                "comment" => $comment
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => false
            ], 500);
        }
    }
    public function validator(Request $request, $reqType = 'like')
    {
        $rules = [
            "postid" => "required|integer|exists:posts,id",
            "userid" => "required|integer|exists:users,id"
        ];
        if ($reqType == 'comment') {
            $rules["comment"] = "required|string";
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return false;
        } else {
            return true;
        }
    }
}
