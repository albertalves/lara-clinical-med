<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Traits\JsonResponse;
use App\Services\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    use JsonResponse;

    protected $cityService;

    public function __construct(CityService $city)
    {
        $this->cityService = $city;
    }

    /**
     * Display a listing of the resource.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        try {
            $cities = $this->cityService->getCities($request);

            return $this->response('Sucesso', [
                'cities' => CityResource::collection($cities)
            ]);
        } catch (\Exception $exception) {
            return $this->response($exception->getMessage(), [], 400);
        }
    }
}
