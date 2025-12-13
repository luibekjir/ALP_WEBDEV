<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryComment extends Model
{
    protected $fillable = [
        'gallery_id',
        'user_id',
        'comment',
        'created_at',
        'updated_at'
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
