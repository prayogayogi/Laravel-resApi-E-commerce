<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Repositories\Admin\AdminRepository;
use App\Traits\Admin;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    use Admin;

    /**
     * index
     *
     * @param mixed $request
     * @return view
     */
    public function index(Request $request): View
    {
        $customers = $this->indexQuery($request, Customer::latest());
        return view('admin.customer.index',[
           'customers' => $customers
        ]);
    }
}
