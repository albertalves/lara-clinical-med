<?php

namespace App\Services;

use App\Repositories\DoctorRepository;
use Illuminate\Http\Request;

class DoctorService
{
    protected $doctorRepository;

    public function __construct(DoctorRepository $repository)
    {
        $this->doctorRepository = $repository;
    }

    public function getDoctors(Request $data)
    {
        return $this->doctorRepository->getDoctors($data);
    }
}