<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    public function movies()
    {
        return $this->belongsToMany('App\Movie','cinemas_movies','cinema_id','movie_id')->withPivot('id','time','date')->withTimestamps();
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
