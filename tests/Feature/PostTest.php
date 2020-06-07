<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_must_be_auth_to_add_post_to_tobic()
    {
        $response = $this->json('POST','/api/topics/1/posts');

        $response->assertStatus(401);
    }

    public function test_it_has_validation_error_for_body()
    {
        $user=[
            'email'=>'mostafa@mohamed',
            'password'=>'62646284'
        ];
        $this->json('POST','/api/login',$user) ;
        $response = $this->json('POST','/api/topics/1/posts');

        $response->assertStatus(422);
        $response->assertJsonStructure(['body'=>[]]);
    }

    public function test_you_must_be_auth_to_apply_update(){

        $this->json('PUT','/api/topics/1/posts/1')->assertStatus(401) ;

    }

    public function test_you_must_be_an_creator_to_apply_update(){

        $user=[
            'email'=>'M@M',
            'password'=>'62646284'
        ];
        $this->json('POST','/api/login',$user) ;
        $this->json('PUT','/api/topics/1/posts/1')->assertStatus(403) ;

    }
    public function test_can_update_post(){

        $user=[
            'email'=>'mostafa@mohamed',
            'password'=>'62646284'
        ];
        $this->json('POST','/api/login',$user) ;
        $response = $this->json('PUT','/api/topics/1/posts/1',['body'=>'welcome']) ;

        $response->assertStatus(200);
        $response->assertJsonFragment(['body'=>'welcome']);
        $response->assertJsonStructure(['data'=>[]]) ;

    }

    public function test_you_must_be_auth_to_apply_delete(){

        $this->json('DELETE','/api/topics/1/posts/1')->assertStatus(401) ;

    }
    public function test_you_must_be_an_creator_to_apply_delete(){

        $user=[
            'email'=>'M@M',
            'password'=>'62646284'
        ];
        $this->json('POST','/api/login',$user) ;
        $this->json('DELETE','/api/topics/1/posts/1')->assertStatus(403) ;

    }
    public function test_you_must_be_auth_to_get_post(){

        $this->json('GET','/api/topics/1/posts/1')->assertStatus(401) ;

    }
    public function test_auth_user_can_get_post(){

        $post = Post::find(1);
        $user=[
            'email'=>'mostafa@mohamed',
            'password'=>'62646284'
        ];
        $this->json('POST','/api/login',$user) ;
        $response = $this->json('GET','/api/topics/1/posts/1') ;

        $response->assertJsonFragment(['body'=>$post->body]) ;
    }
//    public function test_any_user_can_add_post_to_topic(){
//        $user=[
//            'email'=>'M@M',
//            'password'=>'62646284'
//        ];
//        $this->json('POST','/api/login',$user) ;
//        $response = $this->json('POST','/api/topics/1/posts',['body'=>'welcome']);
//
//        $response->assertJsonFragment(['body'=>'welcome']) ;
//
//    }
}
