<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use App\Interfaces\Admin\CategoryInterface;

class CategoryRepository implements CategoryInterface
{
    /**
     * index
     *
     * @param mixed $request
     * @return JsonResponse
     */
    public function index($request)
    {
        $categories = Category::latest()
            ->when(request()->q, function ($categories) {
                $categories = $categories->where('name', 'like', '%' . request()->q . '%');
            })
            ->paginate(10);
        return $categories;
    }

    public function item()
    {
        //
    }
}
