<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    use HasFactory;
    protected $fillable=['post_id','author_id','content','parent_id'];

    public function post(){
        return $this->belongsTo(Post::class);
    }
    public function author(){
        return $this->belongsTo(User::class);
    }
    public function replies(){
        return $this->hasMany(Comment::class,'parent_id');
    }
    public function parent(){
        return $this->belogsTo(Comment::class,'parent_id');
    }
    public function likes()
    {
        return $this->hasMany(Like::class, 'comment_id', 'id')->where('type', 'like');
    }
    
    public function dislikes()
    {
        return $this->hasMany(Like::class, 'comment_id', 'id')->where('type', 'dislike');
    }
    public function reactions()
    {
        return $this->hasMany(Like::class, 'comment_id', 'id');
    }
}
