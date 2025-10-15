<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items', 'order_id', 'product_id')
            ->withPivot('quantity', 'price');
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
