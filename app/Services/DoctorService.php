<?php

namespace App\Services;

use App\Repositories\DoctorRepository;

class DoctorService
{
    protected $doctorRepository;
    protected $consultationRepository;

    public function __construct(DoctorRepository $doctor)
    {
        $this->doctorRepository = $doctor;
    }

    public function getDoctors(string $name = '')
    {
        return $this->doctorRepository->getDoctors($name);
    }

    public function createDoctor(array $data)
    {
        return $this->doctorRepository->createDoctor($data);
    }
}