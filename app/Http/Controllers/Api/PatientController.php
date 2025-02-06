<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Http\Traits\JsonResponse;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    use JsonResponse;

    protected $patientService;

    public function __construct(PatientService $service)
    {
        $this->patientService = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/patients",
     *     tags={"Pacientes"},
     *     summary="Listar pacientes",
     *     description="Endpoint para listar todos os pacientes",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de pacientes",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Sucesso"),
     *             @OA\Property(property="patients", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="João da Silva"),
     *                     @OA\Property(property="phone", type="string", example="11987654321"),
     *                     @OA\Property(property="identity", type="string", example="11122233344")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Nenhum paciente foi encontrado.")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $patients = $this->patientService->getPatients();

            if (empty($patients)) {
                throw new \Exception('Nenhum paciente foi encontrado.');
            }

            return $this->response('Sucesso', [
                'patients' => PatientResource::collection($patients)
            ]);
        } catch (\Exception $exception) {
            return $this->response($exception->getMessage(), [], 400);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/patients",
     *     tags={"Pacientes"},
     *     summary="Criar um novo paciente",
     *     description="Endpoint para criar um novo paciente",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Nome do paciente",
     *                     example="João da Silva"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     description="Telefone do paciente",
     *                     example="11987654321"
     *                 ),
     *                 @OA\Property(
     *                     property="identity",
     *                     type="string",
     *                     format="string",
     *                     description="CPF do paciente",
     *                     example="11122233344"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paciente criado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Paciente criado com sucesso."),
     *             @OA\Property(property="patient", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="João da Silva"),
     *                 @OA\Property(property="phone", type="string", example="11987654321"),
     *                 @OA\Property(property="identity", type="string", example="11122233344")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Não foi possível criar o paciente."),
     *             @OA\Property(property="errors", type="array",
     *                 @OA\Items(type="string", example="Validation error message")
     *             )
     *         )
     *     ),
     *     security={{"bearer_token":{}}}
     * )
     */
    public function store(CreatePatientRequest $request)
    {
        try {
            $patient = $this->patientService->storePatient($request->validated());

            return $this->response('Paciente adicionado com sucesso.', [
                'patients' => new PatientResource($patient)
            ]);
        } catch (\Exception $exception) {
            return $this->response('Não foi possível adicionar o paciente', [$exception->getMessage()], 422);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/patients/{patientId}",
     *     tags={"Pacientes"},
     *     summary="Atualizar um paciente",
     *     description="Endpoint para atualizar um paciente existente",
     *     @OA\Parameter(
     *         name="patientId",
     *         in="path",
     *         description="ID do paciente",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Nome do paciente",
     *                     example="João da Silva"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     description="Telefone do paciente",
     *                     example="11987654321"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paciente atualizado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Paciente atualizado com sucesso."),
     *             @OA\Property(property="patient", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="João da Silva"),
     *                 @OA\Property(property="phone", type="string", example="(11) 98765-4321")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Não foi possível atualizar o paciente."),
     *             @OA\Property(property="errors", type="array",
     *                 @OA\Items(type="string", example="Validation error message")
     *             )
     *         )
     *     ),
     *     security={{"bearer_token":{}}}
     * )
     */
    public function update(UpdatePatientRequest $request)
    {
        try {
            $patient = $this->patientService->updatePatient($request->validated(), $request->patientId);

            if (empty($patient)) {
                throw new \Exception('Nenhum paciente foi encontrado.');
            }

            return $this->response('Paciente atualizado com sucesso.', [
                'patients' => new PatientResource($patient)
            ]);
        } catch (\Exception $exception) {
            return $this->response('Não foi possível editar o paciente', [$exception->getMessage()], 422);
        }
    }
}
