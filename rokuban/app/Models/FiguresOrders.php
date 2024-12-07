<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiguresOrders extends Model
{
    use HasFactory;

    protected $table = 'figuresorders';

    protected $fillable = [
        'order_id',
        'figure_id',
        'price_at_date',
        'pricettc_at_date',
        'quantity'
    ];

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function figure()
    {
        return $this->hasOne(Figure::class);
    }
}
