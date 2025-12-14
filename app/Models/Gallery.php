<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{

    Use HasFactory;

    protected $fillable = [
        'image_url',
        'title',
        'description',
        'created_by',
        'updated_by',
        'like_id',
        'comment_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function likedByUsers(){
        return $this->belongsToMany(User::class, 'likes');
    }

    public function comments()
    {
        return $this->hasMany(GalleryComment::class);
    }
}
