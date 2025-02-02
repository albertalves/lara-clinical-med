<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Http\Traits\JsonResponse;
use App\Services\PatientService;

class PatientController extends Controller
{
    use JsonResponse;

    protected $patientService;

    public function __construct(PatientService $service)
    {
        $this->patientService = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
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
