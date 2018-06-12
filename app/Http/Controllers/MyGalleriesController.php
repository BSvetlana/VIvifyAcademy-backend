<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Gallery;

class MyGalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page = 1, $term = '')
    {
        $user = JWTAuth::parseToken()->authenticate();

        return Gallery::search(($page - 1) * 10, 10, $term, $user);
    }

}

