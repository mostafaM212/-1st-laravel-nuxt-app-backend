<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use App\Topic;
use Illuminate\Http\Request;
class PostLikeController extends Controller
{
    //

    public function store(Request $request,Topic $topic,Post $post)
    {
        $like =new Like() ;

        $like->user()->associate(auth()->user()) ;

        $post->likes()->save($like) ;

        return response()->json(null , 204) ;
    }


}
