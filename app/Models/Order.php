<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_code', 'customer_name', 'customer_phone', 'customer_address',
        'sub_total', 'shipping_fee', 'total_amount', 'payment_method', 'is_paid',
        'status', 'notes'
    ];

    protected $casts = [
        'sub_total' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'is_paid' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}
