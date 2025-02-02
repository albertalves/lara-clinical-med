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

    public function updatePatients(array $data, int $patientId)
    {
        return $this->patientRepository->updatePatient($data, $patientId);
    }
}