<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GalleryRequest;
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
    public function index($page,$term='')
    {
        return Gallery::search(($page - 1) * 10, 10, $term);
               
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryRequest $request)
    {
         $user = JWTAuth::parseToken()->authenticate();

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
        $galleries =  Gallery::with([
            'images' => function($query){
                $query->orderBy('order');
            },
            'comments',
            'owner'
        ])->find($id);

        if(!isset($galleries)){
            abort(404, "Gallery doesn't exist!!!");
        }

        return $galleries;

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
