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
        'destination',
        'courier',
        'shipping_cost',
        'payment_method',
        'total_price',
        'status',
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
