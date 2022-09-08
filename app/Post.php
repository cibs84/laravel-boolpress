<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'slug', 'category_id', 'tag_id'];

    // Relationship Post / Category
    public function category() {
        return $this->belongsTo('App\Category');
    }

    // Relationship Post / Tag
    public function tags() {
        return $this->belongsToMany('App\Tag');
    }
}
