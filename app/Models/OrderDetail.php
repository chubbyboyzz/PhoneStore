<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'product_sku',
        'variant_attributes', 'imei_codes', 'quantity', 'unit_price'
    ];

    protected $casts = [
        'variant_attributes' => 'array',
        'imei_codes' => 'array',
        'unit_price' => 'decimal:2',
        // Thuộc tính line_total là Generated Column dưới DB, ta không can thiệp bằng logic code
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
