<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use App\Repositories\Admin\DashboardRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private $dashboardRepository;
    /**
     * __construct
     *
     * @param DashboardRepository $dashboardRepository
     */
    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        //count invoice
        $pending = $this->dashboardRepository->getInvoice('pending')->count();
        $success = $this->dashboardRepository->getInvoice('success')->count();
        $expired = $this->dashboardRepository->getInvoice('expired')->count();
        $failed  = $this->dashboardRepository->getInvoice('failed')->count();

//        //year and month
        $year   = date('Y');
        $month  = date('m');
//
//        //statistic revenue
//        $revenueMonth = Invoice::whereStatus('success')
//            ->whereMonth('created_at', '=', $month)
//            ->whereYear('created_at', $year)
//            ->sum('grand_total');
        $revenueMonth = $this->dashboardRepository->revenueMonth('success');
        $revenueYear  = Invoice::whereStatus('success')->whereYear('created_at', $year)->sum('grand_total');
        $revenueAll   = Invoice::whereStatus('success')->sum('grand_total');

        return view('admin.dashboard.index', [
            'pending'       => $pending,
            'success'       => $success,
            'expired'       => $expired,
            'failed'        => $failed,
            'revenueMonth'  => $revenueMonth,
            'revenueYear'   => $revenueYear,
            'revenueAll'    => $revenueAll
            ]
        );
    }
}
