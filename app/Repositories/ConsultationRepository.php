<?php

namespace App\Repositories;

use App\Models\Consultation;

class ConsultationRepository
{
    protected $consultation;

    public function __construct(Consultation $consultation)
    {
        $this->consultation = $consultation;
    }

    public function scheduleConsultation(array $request)
    {
        $consultation = $this->consultation->create([
            'doctor_id' => $request['doctorId'],
            'patient_id' => $request['patientId'],
            'date' => $request['date'],
        ]);

        return $consultation;
    }
}