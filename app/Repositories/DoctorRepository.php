<?php

namespace App\Repositories;

use App\Models\Doctor;

class DoctorRepository
{
    protected $doctor;

    public function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor;
    }

    public function getDoctors(string $name = '')
    {
        $doctors = $this->doctor->where('name', 'like', "%$name%")->orderBy('name', 'asc')->paginate(10);

        return $doctors;
    }
    
    public function createDoctor(array $request)
    {
        $doctor = $this->doctor->create([
            'name' => $request['name'],
            'specialty' => $request['specialty'],
            'city_id' => $request['city_id']
        ]);

        return $doctor;
    }
}