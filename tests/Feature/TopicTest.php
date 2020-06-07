<?php

namespace Tests\Feature;

use App\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopicTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_must_be_auth()
    {

         $this->json('POST','/api/topics',[])->assertStatus(401) ;


    }

    public function test_it_has_validation_errors()
    {
        $user= [
            'email'=>'mostafa@mohamed',
            'password'=>'62646284'
        ];
        $this->json('POST','/api/login',$user) ;
        $this->json('POST','/api/topics')->assertStatus(422) ;
    }
    public function test_it_has_validation_error_for_title()
    {
        $user= [
            'email'=>'mostafa@mohamed',
            'password'=>'62646284'
        ];
        $this->json('POST','/api/login',$user) ;
        $this->json('POST','/api/topics',[
            'body'=>'efefefe'
        ])->assertJsonStructure(['title'=>[]]) ;
    }
    public function test_it_has_validation_error_for_body()
    {
        $user= [
            'email'=>'mostafa@mohamed',
            'password'=>'62646284'
        ];
        $this->json('POST','/api/login',$user) ;
        $this->json('POST','/api/topics',[
            'title'=>'efefefe'
        ])->assertJsonStructure(['body'=>[]]) ;
    }

    public function test_guest_user_can_get_topics(){

         $this->json('GET', '/api/topics')->assertStatus(200) ;
    }


    public function test_index_returns_data(){

        $this->json('GET', '/api/topics')->assertJsonStructure(['data'=>[]]) ;
    }


    public function test_index_paginate_data(){

        $this->json('GET', '/api/topics')->assertJsonStructure(['links'=>[]]) ;
    }

    public function test_show_for_all_users(){

        $this->json('GET', '/api/topics/1')->assertStatus(200) ;
    }

    public function test_it_returns_data_for_topic(){

        $this->json('GET', '/api/topics/1')->assertJsonFragment(['id'=>1]) ;
    }

    public function test_it_returns_posts_for_topic(){

        $this->json('GET', '/api/topics/1')->assertJsonStructure(['data'=>['posts'=>[]]]) ;
    }

    public function test_it_returns_user_for_topic(){

        $this->json('GET', '/api/topics/1')->assertJsonStructure(['data'=>['user'=>[]]]) ;
    }

    public function test_the_title_field_is_required_to_update(){

        $user= [
            'email'=>'mostafa@mohamed',
            'password'=>'62646284'
        ];
        $this->json('POST','/api/login',$user) ;

        $response =  $this->json('PUT','/api/topics/2') ;

        $response->assertStatus(422);

        $response->assertJsonStructure(['title'=>[]]) ;

    }

    public function test_the_user_must_be_auth_to_update(){


        $response =  $this->json('PUT','/api/topics/5') ;

        $response->assertStatus(401);

    }

    public function test_the_it_can_update_title(){

        $user= [
            'email'=>'mostafa@mohamed',
            'password'=>'62646284'
        ];
        $this->json('POST','/api/login',$user) ;
        $this->json('PUT','/api/topics/2',['title'=>'welcome']) ;
        $topic = Topic::find(2) ;

        $this->assertEquals('welcome',$topic->title);

    }

    public function test_creator_of_post_onely_can_update_it(){
        $user= [
            'email'=>'M@M',
            'password'=>'62646284'
        ];
        $this->json('POST','/api/login',$user) ;
        $this->json('PUT','/api/topics/2',['title'=>'rrgrgrg'])
            ->assertStatus(403) ;
    }

    public function test_any_user_cannot_delete_it(){
        $user= [
            'email'=>'M@M',
            'password'=>'62646284'
        ];
        $this->json('POST','/api/login',$user) ;
        $this->json('DELETE','/api/topics/2')
            ->assertStatus(403) ;
    }



}
