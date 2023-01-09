<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    /**
     * getProvinces
     *
     * @param mixed $request
     * @return JsonResponse
     */
    public function getProvinces(Request $request): JsonResponse
    {
        $provinces = Province::all();
        return response()->json([
           'success'    => true,
           'message'    => 'List Data Provinces',
           'data'       => $provinces
        ]);
    }

    /**
     * getCities
     *
     * @param mixed $request
     * @return JsonResponse
     */
    public function getCities(Request $request): JsonResponse
    {
        $cities = City::all();
        return response()->json([
           'success'    => true,
           'message'    => 'List Data City',
           'data'       => $cities
        ]);
    }

    /**
     * checkOngkir
     *
     * @param mixed $request
     * @return JsonResponse
     */
    public function checkOngkir(Request $request): JsonResponse
    {
        // Fetch REST API
        $resposes = Http::withHeaders([
            // Api key raja ongkit
            'key' => config('services.rajaongkir.key')
        ])->post('https://api.rajaongkir.com/starter/cost',[
            // Send data
            'origin'        => 113,
            'destination'   => $request->input('city_destination'),
            'weight'        => $request->input('weight'),
            'courier'       => $request->input('courier')
        ]);
        return response()->json([
            'success' => true,
            'message' => 'List Data Cost All Courir: ' . $request->input('courier'),
            'data'      => $resposes['rajaongkir']['results'][0]
        ]);
    }
}
