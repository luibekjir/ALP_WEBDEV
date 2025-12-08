<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{

    Use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'user_id',
        'date',
        'price',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
