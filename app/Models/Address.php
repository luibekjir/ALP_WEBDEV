<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'subdistrict',
        'district',
        'city',
        'zip_code',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
