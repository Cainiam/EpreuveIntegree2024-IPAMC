<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'shippingcompany_id',
        'name',
        'description',
        'price',
        'isVisible'
    ];

    public function shippingcompany()
    {
        return $this->belongsTo(Shippingcompany::class);
    }
}
