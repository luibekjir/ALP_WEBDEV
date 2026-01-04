<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'user_id',
        'receiver_name',
        'phone',
        'address',
        'subdistrict',
        'district',
        'city',
        'zip_code',
        'courier',
        'total_price',
        'status',
        'snap_token',
    ];




    /**
     * Order milik satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order punya banyak item
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

}