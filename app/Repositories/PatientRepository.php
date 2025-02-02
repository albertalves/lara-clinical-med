<?php

namespace App\Repositories;

use App\Models\Patient;

class PatientRepository
{
    protected $patient;

    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    public function updatePatient(array $data, int $patientId)
    {
        $patient = $this->patient->find($patientId);

        if (!$patient || $patient->isEmpty()) {
            return [];
        }

        $patient->update([
            'name'   => $data['name'],
            'phone'  => $data['phone']
        ]);

        return $patient->fresh();
    }
}