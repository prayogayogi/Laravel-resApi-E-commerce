<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Repositories\Api\AuthRepository;
use App\Http\Requests\Api\RegisterRequest;

class AuthController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private AuthRepository $AuthRepository
    ) {
        $this->middleware('auth:api')->except(['register', 'login']);
    }

    /**
     * register
     *
     * @param mixed $request
     * @return Response
     */
    public function register(RegisterRequest $request)
    {
        $response = $this->AuthRepository->register($request);
        return $response;
    }

    /**
     * register
     *
     * @param mixed $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $response = $this->AuthRepository->login($request);
        return $response;
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
        ], 200);
    }
}
