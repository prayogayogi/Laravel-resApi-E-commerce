<?php

namespace App\Repositories\Api;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Api\AuthInterface;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthRepository implements AuthInterface
{
    /**
     * register
     *
     * @return ResponseJson
     */
    public function register($request): JsonResponse
    {
        $customer = Customer::create([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => Hash::make($request->input('password'))
        ]);

        $token = JWTAuth::fromUser($customer);
        if ($customer) {
            return response()->json([
                'success'    => true,
                'user'       => $customer,
                'token'      => $token
            ]);
        } else {
            return response()->json([
                'success' => false
            ], 409);
        }
    }

    /**
     * register
     *
     * @param mixed $request
     * @return JsonResponse
     */
    public function login($request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $token = auth()->guard('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Email or password is incorrect'
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'user' => auth()->guard('api')->user(),
                'token' => $token
            ]);
        }
    }
}
