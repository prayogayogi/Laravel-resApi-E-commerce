<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['register', 'login']);
    }

    /**
     * register
     *
     * @param mixed $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->input(),[
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:customers',
            'password' => 'required|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $customer = Customer::create([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => Hash::make($request->input('password'))
        ]);

        $token = JWTAuth::fromUser($customer);

        if($customer){
            return response()->json([
               'success'    => true,
               'user'       => $customer,
               'token'      => $token
            ]);
        }

        return response()->json([
           'success' => false
        ], 409);
    }

    /**
     * register
     *
     * @param mixed $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->input(),[
           'email'      => 'required|email',
           'password'   => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('email','password');

        $token = auth()->guard('api')->attempt($credentials);

        if(!$token){
            return response()->json([
               'success' => false,
               'message' => 'Email and password incorrect'
            ], 401);
        }
        return response()->json([
            'success'   => true,
            'user'      => auth()->guard('api')->user(),
            'token'     => $token
        ], 201);
    }

    /**
     * getUser
     *
     * @return JsonResponse
     */
    public function getUser(): JsonResponse
    {
        return response()->json([
            'success'   => true,
            'user'      => auth()->user()
        ],200);
    }
}
