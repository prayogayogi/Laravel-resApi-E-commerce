<?php

namespace App\Interfaces\Admin;

interface CategoryInterface
{
    /**
     * index
     *
     * @param mixed $request
     * @return JsonResponse
     */
    public function index($request);
}
