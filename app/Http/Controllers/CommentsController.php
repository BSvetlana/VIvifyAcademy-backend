<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;
use App\Comment;
use App\Gallery;

class CommentsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param CommentRequest $request
     * @param int $gallery_id
     * @return Comment
     */
    public function store(CommentRequest $request, $gallery_id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $comment = new Comment();
        $gallery = Gallery::find($gallery_id);

        $comment->owner_id = $user->id;
        $comment->gallery_id = $gallery_id;
        $comment->body = $request->input('body');

        $comment->save();

        $comment->owner = $user;
        $comment->gallery = $gallery;

        $comment->with('owner');

        return $comment;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @throws \Exception
     *  @return array
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);

        $comment->delete();

        return['success'=>true];
    }
}

