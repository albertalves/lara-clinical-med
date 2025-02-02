<?php

namespace App\Services;

use App\Repositories\PatientRepository;

class PatientService
{
    protected $patientRepository;

    public function __construct(PatientRepository $patient)
    {
        $this->patientRepository = $patient;
    }

    public function updatePatient(array $data, int $patientId)
    {
        return $this->patientRepository->updatePatient($data, $patientId);
    }

    public function storePatient(array $data)
    {
        return $this->patientRepository->storePatient($data);
    }
}