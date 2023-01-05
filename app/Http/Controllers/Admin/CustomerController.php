<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * index
     *
     * @return view
     */
    public function index(): View
    {
        $customers = Customer::latest()->when(request()->q, function($customers){
           $customers =  $customers->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.customer.index',[
           'customers' => $customers
        ]);
    }
}
