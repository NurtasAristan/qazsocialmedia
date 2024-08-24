<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
    ];

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class)->latest();
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function userLikes() {
        return $this->hasMany(Like::class)->where('user_id', auth()->id());
    }

}