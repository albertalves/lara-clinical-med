<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateConsultationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'doctorId' => 'required|exists:doctors,id',
            'patientId' => 'required|exists:patients,id',
            'date' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'doctorId.required' => 'O campo doctor_id é obrigatório.',
            'doctorId.exists' => 'Este médico não existe, informe um doctor_id válido.',
            'patientId.required' => 'O campo patient_id é obrigatório.',
            'patientId.exists' => 'Este paciente não existe, informe um patient_id válido.',
            'date.required' => 'O campo data é obrigatório.'
        ];
    }
}
