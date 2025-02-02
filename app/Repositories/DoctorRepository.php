<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;

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
            'city_id' => $request['cityId']
        ]);

        return $doctor;
    }

    public function getPatients(int $doctor_id, bool $onlyScheduled, $name = '')
    {
        $patients = Patient::with('consultations')
                            ->whereHas('consultations', function ($query) use ($doctor_id, $onlyScheduled) {
                                $query->where('doctor_id', $doctor_id);
                                if ($onlyScheduled) {
                                    $query->whereDate('date', '>=', Carbon::today());
                                } 
                            })
                            ->where('name', 'like', "%$name%")
                            ->orderBy('name', 'asc')
                            ->paginate(10);

        if (!$patients || $patients->isEmpty()) {
            return [];
        }
     
        return $patients;
    }
}