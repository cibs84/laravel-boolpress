<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Relationship One to Many between Category and Post models
    public function posts() {
        return $this->hasMany('App\Post');
    } 
}
