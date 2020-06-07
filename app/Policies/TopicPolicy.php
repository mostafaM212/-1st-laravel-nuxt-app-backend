<?php

namespace App\Policies;

use App\Topic;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TopicPolicy
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

    public function update(User $user,Topic $topic ){

        return Auth::user()->id === $topic->user->id ;
    }

    public function delete(User $user ,Topic $topic){
        return Auth::user()->id === $topic->user->id ;
    }
}
