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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
