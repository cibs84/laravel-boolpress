<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // Relationship Tag / Post
    public function posts() {
        return $this->belongsToMany('App\Post');
    }
}
