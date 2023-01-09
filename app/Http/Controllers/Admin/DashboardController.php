<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        //count invoice
        $pending = Invoice::whereStatus('pending')->count();
        $success = Invoice::whereStatus('success')->count();
        $expired = Invoice::whereStatus('expired')->count();
        $failed  = Invoice::whereStatus('failed')->count();

        //year and month
        $year   = date('Y');
        $month  = date('m');

        //statistic revenue
        $revenueMonth = Invoice::whereStatus('success')
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', $year)
            ->sum('grand_total');
        $revenueYear  = Invoice::whereStatus('success')->whereYear('created_at', $year)->sum('grand_total');
        $revenueAll   = Invoice::whereStatus('success')->sum('grand_total');

        return view('admin.dashboard.index', compact('pending', 'success', 'expired', 'failed', 'revenueMonth', 'revenueYear', 'revenueAll'));
    }
}
