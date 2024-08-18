<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable=['title','content','category_id','views','main_photo_url'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class)->likes();
    }

    public function dislikes()
    {
        return $this->hasMany(Like::class)->dislikes();
    }

    public function isLikedByUser($userId){
        return $this->likes()->where('user_id',$userId)->exists();
    }

    public function isDislikedByUser($userId){

        return $this->dislike()->where('user_id',$userId)->exists();
    }
}
