<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicCreateRequest;
use App\Http\Requests\TopicUpdateRequest;
use App\Http\Resources\TopicResource;
use App\Post;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    //

    public function index(){
        $topics = Topic::latestFirst()->paginate(5) ;

        return TopicResource::collection($topics) ;
    }

    public function store(TopicCreateRequest $request){

        $topic = new Topic() ;

        $topic->title = $request->body ;

        $topic->user()->associate($request->user()) ;

        $post = new Post();

        $post->body = $request->body ;

        $post->user()->associate($request->user()) ;

        $topic->save() ;

        $topic->posts()->save($post) ;

        return new TopicResource($topic) ;
    }

    public function show(Topic $topic){

        return new TopicResource($topic) ;
    }

    public function update(TopicUpdateRequest $request,Topic $topic){

        $this->authorize('update',$topic) ;
        $topic->title = $request->title ;

        $topic->save() ;

        return new TopicResource($topic) ;
    }

    public function destroy(Topic $topic){

        $this->authorize('delete',$topic) ;

        $topic->delete() ;
        return response()->json(null ,204) ;
    }
}
