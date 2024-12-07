<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'price',
        'pricettc',
        'shipping_at_date',
        'paypal_status',
        'shipping_id',
        'tracker',
        'isVisible'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function figures()
    {
        return $this->belongsToMany(Figure::class, 'figuresorders')
                    ->withPivot('price_at_date', 'pricettc_at_date', 'quantity')
                    ->withTimestamps();
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }

    public function paypalTransaction()
    {
        return $this->hasOne(paypalTransaction::class);
    }
}
