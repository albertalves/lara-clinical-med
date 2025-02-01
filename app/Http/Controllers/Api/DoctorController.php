<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Http\Traits\JsonResponse;
use App\Services\DoctorService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    use JsonResponse;

    protected $doctorService;

    public function __construct(DoctorService $service)
    {
        $this->doctorService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $doctors = $this->doctorService->getDoctors($request);

            return $this->response('Sucesso', [
                'doctors' => DoctorResource::collection($doctors)
            ]);
        } catch (\Exception $exception) {
            return $this->response($exception->getMessage(), [], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
    }
}
