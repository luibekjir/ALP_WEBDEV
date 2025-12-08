<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'image_url',
        'title',
        'decription',
        'created_by',
        'updated_by',
        'like_id',
        'comment_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
