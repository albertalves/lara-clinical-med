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
            'doctor_id' => $request['doctor_id'],
            'patient_id' => $request['patient_id'],
            'date' => $request['date'],
        ]);

        return $consultation;
    }
}