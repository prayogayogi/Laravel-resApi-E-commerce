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

    /**
     * Store
     *
     * @param mixed $request
     * @return void
     */
    public function store($request);

    /**
     * Update
     * @param mixed $request, $category
     * @return void
     */
    public function update($request, $category);

    /**
     * destroy
     * @param mixed $category
     * @return json
     */
    public function destroy($category);
}
