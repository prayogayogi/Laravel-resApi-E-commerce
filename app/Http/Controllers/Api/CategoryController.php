<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = Category::latest()->get();

        return response()->json([
            'success'       => true,
            'message'       => 'List data category',
            'categories'    => $categories
        ]);
    }

    /**
     * show
     *
     * @param mixed slug
     * @return JsonResponse
     */
    public function show($slug): JsonResponse
    {
        $category = Category::whereSlug($slug)->first();

        if($category){
            return response()->json([
               'success'    => true,
               'message'    => 'List data product by category: ' . $category->name,
               'product'    => $category->Products()->latest()->get()
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data Product By Category Tidak Ditemukan',
            ],404);
        }

    }

    /**
     * categoryHeader
     *
     * @return JsonResponse
     */
    public function categoryHeader(): JsonResponse
    {
        $categories = Category::latest()->take(5)->get();

        return response()->json([
            'success'       => true,
            'message'       => 'List Data Category Header',
            'categories'    => $categories
        ]);
    }
}
