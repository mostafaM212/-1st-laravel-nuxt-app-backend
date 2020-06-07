<?php


namespace App\Traits;


use App\Topic;

trait UserTrait
{
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        //return the primary key of the user
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function ownsTopic(Topic $topic){
        return $this->id === $topic->user->id ;
    }

    public function hasLikedPost(){
        
    }

}
