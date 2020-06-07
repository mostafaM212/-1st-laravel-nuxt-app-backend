<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Orderable ;
class Post extends Model
{
    use Orderable ;
    //
    protected $fillable = [
        'body'
    ];
    public function topic(){

        return $this->belongsTo(Topic::class ,'topic_id') ;
    }
   public function user(){

        return $this->belongsTo(User::class) ;
   }

   public function likes(){

        return $this->morphMany(Like::class,'likeable') ;
   }
}
