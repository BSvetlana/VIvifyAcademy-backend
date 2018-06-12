<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Comment;
use App\Gallery;

class CommentsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $gallery_id)
    {
        $user = User::all()->first();
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return['success'=>true];
    }
}

