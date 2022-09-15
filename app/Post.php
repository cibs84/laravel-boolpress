<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'slug', 'cover', 'category_id', 'tag_id'];

    // Relationship One to Many between Category and Post models
    public function category() {
        return $this->belongsTo('App\Category');
    }

    // Relationship Many to Many between Post and Tag models
    public function tags() {
        return $this->belongsToMany('App\Tag');
    }
}
