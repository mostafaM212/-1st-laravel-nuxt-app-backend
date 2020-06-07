<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_has_validation_error_for_email()
    {
        $response = $this->post('/api/register',['name'=>'efefef']);

        $response->assertJsonStructure(['email'=>[]]);

        $response->assertJsonStructure(['password'=>[]]);

        $response->assertStatus(422);
    }


    public function test_user_can_login(){

        $response = $this->post('/api/login',[
            'email'=>'mostafa@mohamed',
            'password'=>'62646284'
        ]);

        $response->assertJsonStructure(['meta'=>[]]) ;
    }


    public function test_user_canot_login_with_wrong_email(){

        $response = $this->post('/api/login',[
            'email'=>'mostafa@mo0hamed',
            'password'=>'62646284'
        ]);

        $response->assertJsonStructure(['errors'=>[]]) ;

        $response->assertStatus(401) ;
    }

    public function test_it_has_validation_error_for_login()
    {
        $response = $this->post('/api/register');

        $response->assertJsonStructure(['email'=>[]]);

        $response->assertJsonStructure(['password'=>[]]);

        $response->assertStatus(422);
    }

    public function test_we_can_get_user_info(){
        $user= [
            'email'=>'mostafa@mohamed',
            'password'=>'62646284'
        ];
        $this->json('POST','/api/login',$user) ;
        $response = $this->json('GET','/api/user') ;

        $response->assertJsonFragment(['name'=>'mostafa']);

    }

    public function test_we_can_logout(){

        $user= [
            'email'=>'mostafa@mohamed',
            'password'=>'62646284'
        ];
        $this->json('POST','/api/login',$user) ;
        $response = $this->post('/api/logout') ;

        $response->assertStatus(200);

    }


}
