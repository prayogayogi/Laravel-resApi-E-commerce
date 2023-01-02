<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'customer_id', 'price', 'quantity', 'weight'
    ];

    /**
     * product
     *
     * @return void
     */
    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * customer
     *
     * @return void
     */
    public function Customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
