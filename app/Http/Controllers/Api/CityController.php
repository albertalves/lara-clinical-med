<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\DoctorResource;
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
     * @OA\Get(
     *      path="/api/cities",
     *      tags={"Cidades"},
     *      summary="Listar cidades",
     *      description="Endpoint para listar cidades",
     *      @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filtrar por nome da Cidade",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Lista de cidades",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Sucesso"),
     *              @OA\Property(property="cities", type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="name", type="string", example="São Paulo"),
     *                      @OA\Property(property="state", type="string", example="SP")
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Nenhuma cidade foi encontrada.")
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        try {
            $cities = $this->cityService->getCities($request);

            if (empty($cities)) {
                throw new \Exception('Nenhuma cidade foi encontrada.');
            }

            return $this->response('Sucesso', [
                'cities' => CityResource::collection($cities)
            ]);
        } catch (\Exception $exception) {
            return $this->response($exception->getMessage(), [], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/cities/{cityId}/doctors",
     *     tags={"Médicos"},
     *     summary="Listar médicos de uma cidade",
     *     description="Endpoint para listar médicos de uma cidade",
     *     @OA\Parameter(
     *         name="cityId",
     *         in="path",
     *         description="ID da cidade",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listar médicos de uma cidade",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Sucesso"),
     *             @OA\Property(property="doctors", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Dra. Alessandra Moura"),
     *                     @OA\Property(property="specialty", type="string", example="Neurologista"),
     *                     @OA\Property(property="cityId", type="integer", example=1)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Nenhum medico e/ou cidade foram encontrados.")
     *         )
     *     ),
     *     security={{"bearer_token":{}}}
     * )
     */
    public function doctors(Request $request) {
        try {
            $doctors = $this->cityService->getDoctorsFromCity($request);

            if (empty($doctors)) {
                throw new \Exception('Nenhum medico e/ou cidade foram encontrados.');
            }

            return $this->response('Sucesso', [
                'doctors' => DoctorResource::collection($doctors)
            ]);
        } catch (\Exception $exception) {
            return $this->response($exception->getMessage(), [], 400);
        }
    }
}
