<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostLike;
use App\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    //
    public function likePost(Request $request)
    {
        $validator = $this->validator($request, 'like');
        if ($validator->fails()) {
            return response()->json([
                "status" => $validator->errors()->first()
            ], 400);
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
        $validator = $this->validator($request, 'comment');
        if ($validator->fails()) {
            return response()->json([
                "status" => $validator->errors()->first()
            ], 400);
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
                "status" => "Something went wrong"
            ], 500);
        }
    }

    public function deleteComment(Request $request)
    {
        $validator = $this->validator($request, 'comment-delete');
        if ($validator->fails()) {
            return response()->json([
                "status" => $validator->errors()->first()
            ], 400);
        }
        $comment = PostComment::find($request->commentid);
        if (!$comment || !Gate::allows('change-comment', $comment)) {
            return response()->json([
                "status" => "Unauthorized"
            ], 403);
        }
        DB::beginTransaction();
        try {
            $comment = PostComment::find($request->commentid);
            $comment->delete();
            DB::commit();
            return response()->json([
                "status" => true
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
        $rules = [];
        if ($reqType == 'like') {
            $rules["postid"] = "required|integer|exists:posts,id";
            $rules["userid"] = "required|integer";
        }
        if ($reqType == 'comment') {
            $rules["postid"] = "required|integer|exists:posts,id";
            $rules["userid"] = "required|integer";
            $rules["comment"] = "required|string";
        }
        if ($reqType == 'comment-delete') {
            $rules["userid"] = "required|integer";
            $rules["commentid"] = "required|integer|exists:post_comments,id";
        }
        $validator = Validator::make($request->all(), $rules);
        return $validator;
    }
}
