<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isInStock($quantity = 1)
    {
        return $this->stock >= $quantity;
    }

    public function decreaseStock($quantity)
    {
        if ($this->isInStock($quantity)) {
            $this->stock -= $quantity;
            return $this->save();
        }
        return false;
    }
}
