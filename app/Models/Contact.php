<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'customer_name', 'customer_email', 'customer_phone',
        'subject', 'message', 'status', 'admin_note'
    ];
}
