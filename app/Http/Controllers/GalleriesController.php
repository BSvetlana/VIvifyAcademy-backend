<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\User;
use App\Image;
use App\Comment;

class GalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Gallery::all();
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Gallery::all()->first();

        $gallery = new Gallery();

        $gallery->name = $request->input('name');
        $gallery->description = $request->input('description');
        $gallery->owner_id = $user->id;

        $gallery->save();

        $imagesArray = $request->input('images');
        $images = [];

        foreach($imagesArray as $image){
            $newImage = new Image($image);

            $images[] = $newImage;
        }

        $gallery->images()->saveMany($images);

        return $gallery;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Gallery::with([
            'images' => function($query){
                $query->orderBy('order');
            },
            'comments',
            'owner'
        ])->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gallery = Gallery::find($id);

        $gallery->name = $request->input('name');
        $gallery->description = $request->input('description');

        $gallery->save();

        return $gallery;
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = Gallery::find($id);
        $gallery->delete();

        return ['success'=>true];
        
    }
}
