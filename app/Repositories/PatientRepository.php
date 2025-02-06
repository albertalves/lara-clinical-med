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

    public function getPatients()
    {
        return $this->patient->all();
    }

    public function updatePatient(array $data, int $patientId)
    {
        $patient = $this->patient->find($patientId);

        if (!isset($patient->id)) {
            return [];
        }

        $patient->update([
            'name'   => $data['name'],
            'phone'  => $data['phone']
        ]);

        return $patient->fresh();
    }

    public function storePatient(array $data)
    {   
        $patient = $this->patient->create([
            'name'   => $data['name'],
            'phone'  => $data['phone'],
            'identity'  => $data['identity'],
        ]);

        return $patient;
    }
}