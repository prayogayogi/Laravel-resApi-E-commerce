<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Traits\Admin;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    use Admin;
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $invoices = Invoice::latest()->when(request()->q, function($invoices){
        $invoices = $invoices->where('invoice', 'like', '%' . request()->q . '%');
        })->paginate(10);
        return view('admin.order.index',[
            'invoices' => $invoices
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return View
     */
    public function show(Invoice $invoice): View
    {
        return view('admin.order.show',[
            'invoice' => $invoice
        ]);
    }
}
