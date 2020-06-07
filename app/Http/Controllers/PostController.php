<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Post;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //

    public function store(PostRequest $request ,Topic $topic){
        $post = new Post() ;

        $post->body =$request->body ;

        $post->user()->associate(Auth::user()) ;

        $topic->posts()->save($post) ;

        return new PostResource($post) ;
    }

    public function update(UpdatePostRequest $request ,Topic $topic ,Post $post ){

        $this->authorize('update',$post) ;

        $post->body = $request->body ;

        $post->save() ;

        return new PostResource($post) ;
    }


    public function destroy(Topic $topic,Post $post ){

        $this->authorize('delete',$post) ;
        $post->delete() ;

        return response()->json(null , 204) ;
    }

    public function show(Topic $topic ,Post $post){

        return new PostResource( $post) ;
    }
}
