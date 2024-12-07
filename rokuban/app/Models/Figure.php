<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Figure extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'price',
        'tva_id',
        'brand_id',
        'collection',
        'character_name',
        'series_title',
        'sculptor_name',
        'material',
        'height',
        'scale_id',
        'release_date',
        'stock_qty',
        'reference',
        'ean',
        'state',
        'category_id',
        'isVisible'
    ];

    //Return if one figure has enough stock or not
    public function hasStock($requestedQuantity)
    {
        return $this->quantity >= $requestedQuantity;
    }

    public function tvas()
    {
        return $this->belongsTo(Tva::class);
    }

    public function scales()
    {
        return $this->belongsTo(Scale::class);
    }

    public function brands()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'figuresorders')
                    ->withPivot('price_at_date', 'pricettc_at_date', 'quantity')
                    ->withTimestamps();
    }
}
