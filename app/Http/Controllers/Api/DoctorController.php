<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateConsultationRequest;
use App\Http\Requests\CreateDoctorRequest;
use App\Http\Resources\ConsultationResource;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\PatientResource;
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
     * @OA\Get(
     *     path="/api/doctors",
     *     tags={"Médicos"},
     *     summary="Listar médicos",
     *     description="Endpoint para listar médicos",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filtrar por nome do médico",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de médicos",
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
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Houve um erro ao buscar os médicos."),
     *             @OA\Property(property="errors", type="array",
     *                 @OA\Items(type="string", example="Validation error message")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            $doctors = $this->doctorService->getDoctors($request->name ?? '');

            return $this->response('Sucesso', [
                'doctors' => DoctorResource::collection($doctors)
            ]);
        } catch (\Exception $exception) {
            return $this->response('Houve um erro ao buscar os médicos.', [$exception->getMessage()], 422);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/doctors",
     *     tags={"Médicos"},
     *     summary="Criar um novo médico",
     *     description="Endpoint para criar um novo médico",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Nome do médico",
     *                     example="Dra. Alessandra Moura"
     *                 ),
     *                 @OA\Property(
     *                     property="specialty",
     *                     type="string",
     *                     description="Especialidade do médico",
     *                     example="Neurologista"
     *                 ),
     *                 @OA\Property(
     *                     property="cityId",
     *                     type="integer",
     *                     description="ID da cidade",
     *                     example=1
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Médico criado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Médico criado com sucesso."),
     *             @OA\Property(property="doctor", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Dra. Alessandra Moura"),
     *                 @OA\Property(property="specialty", type="string", example="Neurologista"),
     *                 @OA\Property(property="cityId", type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Não foi possível concluir seu cadastro."),
     *             @OA\Property(property="errors", type="array",
     *                 @OA\Items(type="string", example="Validation error message")
     *             )
     *         )
     *     ),
     *     security={{"bearer_token":{}}}
     * )
     */
    public function store(CreateDoctorRequest $request)
    {
        try {
            $doctors = $this->doctorService->createDoctor($request->validated());

            return $this->response('Médico criado com sucesso.', [
                'doctor' => new DoctorResource($doctors)
            ]);
        } catch (\Exception $exception) {
            return $this->response('Não foi possível concluir seu cadastro.', [$exception->getMessage()], 422);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/doctors/consultation",
     *     tags={"Médicos"},
     *     summary="Agendar uma consulta",
     *     description="Endpoint para agendar uma consulta com um médico",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="doctorId",
     *                     type="integer",
     *                     description="ID do médico",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="patientId",
     *                     type="integer",
     *                     description="ID do paciente",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="date",
     *                     type="string",
     *                     format="date-time",
     *                     description="Data e hora da consulta",
     *                     example="2023-10-01 10:00:00"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Consulta agendada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Consulta agendada com sucesso."),
     *             @OA\Property(property="consultation", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="doctorId", type="integer", example=1),
     *                 @OA\Property(property="patient_id", type="integer", example=1),
     *                 @OA\Property(property="date", type="string", format="date-time", example="2023-10-01T10:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Não foi possível agendar a consulta."),
     *             @OA\Property(property="errors", type="array",
     *                 @OA\Items(type="string", example="Validation error message")
     *             )
     *         )
     *     ),
     *     security={{"bearer_token":{}}}
     * )
     */
    public function scheduleConsultation(CreateConsultationRequest $request)
    {
        try {
            $consultation = $this->doctorService->scheduleConsultation($request->validated());

            return $this->response('Consulta criada com sucesso.', [
                'consultation' => new ConsultationResource($consultation)
            ]);
        } catch (\Exception $exception) {
            return $this->response('Não foi possível criar a consulta.', [$exception->getMessage()], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/doctors/{doctorId}/patients",
     *     tags={"Médicos"},
     *     summary="Listar pacientes de um médico",
     *     description="Endpoint para listar pacientes de um médico",
     *     @OA\Parameter(
     *         name="doctorId",
     *         in="path",
     *         description="ID do médico",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="onlyScheduled",
     *         in="query",
     *         description="Consultas não realizadas",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filtrar por nome do paciente",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
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
     *                     @OA\Property(property="email", type="string", example="joao.silva@example.com"),
     *                     @OA\Property(property="phone", type="string", example="(11) 98765-4321")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Não foi possível listar os pacientes."),
     *             @OA\Property(property="errors", type="array",
     *                 @OA\Items(type="string", example="Validation error message")
     *             )
     *         )
     *     ),
     *     security={{"bearer_token":{}}}
     * )
     */
    public function patients(Request $request)
    {
        try {
            $doctorId = $request->doctorId;
            $onlyScheduled = $request->onlyScheduled === "true";
            $name = $request->name ?? '';
            
            $patients = $this->doctorService->getPatients($doctorId, $onlyScheduled, $name);

            if (empty($patients)) {
                throw new \Exception('Nenhum paciente foi encontrado.');
            }

            return $this->response('Sucesso.', [
                'patients' => PatientResource::collection($patients)
            ]);
        } catch (\Exception $exception) {
            return $this->response('Não foi possível listar os pacientes', [$exception->getMessage()], 422);
        }
    }
}
