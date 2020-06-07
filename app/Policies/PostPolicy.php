<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user ,Post $post){

        return Auth::user()->id === $post->user->id ;
    }

    public function delete(User $user ,Post $post){

        return Auth::user()->id === $post->user->id ;
    }

    public function like(User $user , Post $post){
        return !Auth::user()->id === $post->user->id ;
    }
}
