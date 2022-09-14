<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // Relationship Many to Many between Post and Tag models
    public function posts() {
        return $this->belongsToMany('App\Post');
    }
}
