<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\DashboardInterface;
use App\Models\Invoice;

class DashboardRepository implements DashboardInterface
{
    /**
     * getInvoice
     *
     * @param $status
     * @return mixed|void
     */
    public function getInvoice($status)
    {
        $invoice = Invoice::whereStatus($status);
        return $invoice;
    }

    public function revenueMonth($status)
    {
        //year and month
        $year   = date('Y');
        $month  = date('m');

        //statistic revenue
        $revenueMonth = Invoice::whereStatus($status)
            ->whereMonth('created_at', '=', $month)
            ->whereYear('created_at', $year)
            ->sum('grand_total');
        return $revenueMonth;
    }
}
