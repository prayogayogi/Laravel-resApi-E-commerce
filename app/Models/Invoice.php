<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'invoice', 'customer_id', 'courier', 'service', 'cost_courier', 'weight', 'name', 'phone', 'province', 'city', 'address', 'status', 'snap_token', 'grand_total'
    ];

    /**
     * Orders
     *
     * @return void
     */
    public function Order()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * customer
     *
     * @return void
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
