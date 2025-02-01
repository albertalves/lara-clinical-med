<?php

namespace App\Repositories;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorRepository
{
    protected $doctor;

    public function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor;
    }

    public function getDoctors(Request $request)
    {
        $name = $request->query('name');
        $doctors = Doctor::where('name', 'like', "%$name%")->orderBy('name', 'asc')->paginate(10);

        return $doctors;
    }
}