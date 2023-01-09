<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $carts = Cart::with(['Product'])->whereCustomer_id(auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json([
           'success' => true,
           'message' => 'List Data Cart',
            'cart'   => $carts
        ]);
    }

    /**
     * store
     *
     * @param mixed $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $item = Cart::whereProduct_id($request->input('product_id'))->whereCustomer_id($request->input('customer_id'));
        if($item->count()){

            // Incerment quantity
            $item->incerment('quantity');
            $item = $item->first();

            // Sum pric * quantity
            $price = $request->input('price') * $item->quantity;

            // Sum weight
            $weight = $request->input('weight') * $item->weight;
            $item->update([
               'price'  => $price,
               'weight' => $weight
            ]);
        }else{
            $item = Cart::create([
               'product_id'     => $request->input('product_id'),
               'customer_id'    => $request->input('customer_id'),
               'quantity'       => $request->input('quantity'),
               'price'          => $request->input('price'),
               'weight'         => $request->input('weight')
            ]);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Success Add To Cart',
            'quantity'  => $item->quantity,
            'product'   => $item->Product
        ]);
    }

    /**
     * getCartTotal
     *
     * @return JsonResponse
     */
    public function getCartTotal(): JsonResponse
    {
        $carts = Cart::with(['Product'])->whereCustomer_id(auth()->user()->id)
                    ->orderBy('created_at', 'desc')->sum('price');
        return response()->json([
            'success'   => true,
            'message'   => 'Total Cart Price',
            'total'     => $carts
        ]);
    }

    /**
     * getCartTotalWeight
     *
     * @return JsonResponse
     */
    public function getCartTotalWeight(): JsonResponse
    {
        $carts = Cart::with(['Product'])->whereCustomer_id(auth()->user()->id)
                    ->orderBy('created_at', 'desc')->sum('weight');
        return response()->json([
            'success'   => true,
            'message'   => 'Total Cart Weight',
            'total'     => $carts
        ]);
    }

    /**
     * removeCart
     *
     * @param mixed $request
     * @return JsonResponse
     */
    public function removeCart(Request $request): JsonResponse
    {
        Cart::with(['Product'])->whereId($request->input('cart_id'))->delete();
        return response()->json([
           'success'    => true,
           'message'    => 'Remove Item Cart'
        ]);
    }

    /**
     * removeAllCart
     *
     * @param mixed $request
     * @return JsonResponse
     */
    public function removeAllCart(Request $request): JsonResponse
    {
        Cart::with(['Product'])->whereCustomer_id(auth()->guard('api')->user()->id)->delete();
        return response()->json([
           'success'    => true,
           'message'    => 'Remove All Item in Cart'
        ]);
    }
}
