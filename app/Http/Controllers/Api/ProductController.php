<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $products = Product::latest()->get();

        return response()->json([
           'success'    => true,
           'message'    => 'List data product',
           'products'   => $products
        ],200);
    }

    /**
     * show
     *
     * @param mixed $slug
     * @return JsonResponse
     */
    public function show($slug): JsonResponse
    {
        $product = Product::whereSlug($slug)->first();

        if($product){
            return response()->json([
                'success' => true,
                'message' => 'Detail data product',
                'product' => $product
            ],200);
        }else{
            return response()->json([
               'success' => false,
               'message' => 'Data Product tidak ditemukan'
            ], 404);
        }
    }
}
