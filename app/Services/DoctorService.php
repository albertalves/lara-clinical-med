<?php

namespace App\Services;

use App\Models\Consultation;
use App\Repositories\ConsultationRepository;
use App\Repositories\DoctorRepository;
use Carbon\Carbon;

class DoctorService
{
    protected $doctorRepository;
    protected $consultationRepository;

    public function __construct(DoctorRepository $doctor, ConsultationRepository $consultation)
    {
        $this->doctorRepository = $doctor;
        $this->consultationRepository = $consultation;
    }

    public function getDoctors(string $name = '')
    {
        return $this->doctorRepository->getDoctors($name);
    }

    public function createDoctor(array $data)
    {
        return $this->doctorRepository->createDoctor($data);
    }

    public function scheduleConsultation(array $data)
    {
        $interval = [
            Carbon::parse($data['date'])->subHour(), 
            Carbon::parse($data['date'])->addHour()
        ];

        $alreadyHasConsultation = Consultation::where('doctor_id', $data['doctor_id'])
                                                ->whereBetween('date', $interval)
                                                ->exists();

        if ($alreadyHasConsultation) {
            throw new \Exception('Horário indisponível. Por favor, tente novamente em uma hora mais tarde ou escolha um médico diferente.');
        }

        return $this->consultationRepository->scheduleConsultation($data);
    }
}