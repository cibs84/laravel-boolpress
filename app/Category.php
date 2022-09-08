<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Relationship Category / Post
    public function posts() {
        return $this->hasMany('App\Post');
    } 
}
