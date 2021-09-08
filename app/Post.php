<?php

namespace App;

use App\User;
use App\Category;
use App\PostLike;
use App\PostComment;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class)->orderBy('id', 'DESC');
    }
}
