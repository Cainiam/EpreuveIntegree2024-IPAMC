<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaypalTransaction extends Model
{
    use HasFactory;

    protected $table = 'paypaltransactions';

    protected $fillable = [
        'paypal_transactions_id',
        'paypal_transactions_status',
        'paypal_client_mail',
        'paypal_pricewtax',
        'paypal_currency_code',
        'order_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
