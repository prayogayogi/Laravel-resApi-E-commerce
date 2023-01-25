<?php

namespace App\Interfaces\Admin;

interface DashboardInterface
{
    /**
     * getInvoice
     *
     * @param $status
     * @return mixed
     */
    public function getInvoice($status);

    /**
     * revenueMonth
     *
     * @param $status
     * @return mixed
     */
    public function revenueMonth($status);
}
