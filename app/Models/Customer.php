<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Authenticatable
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * invoice
     *
     * @return void
     */
    public function Invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * carts
     *
     * @return void
     */
    public function Carts()
    {
        return $this->hasMany(Cart::class);
    }
}
