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
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'doctor_id.required' => 'O campo doctor_id é obrigatório.',
            'doctor_id.exists' => 'Este médico não existe, informe um doctor_id válido.',
            'patient_id.required' => 'O campo patient_id é obrigatório.',
            'patient_id.exists' => 'Este paciente não existe, informe um patient_id válido.',
            'date.required' => 'O campo data é obrigatório.'
        ];
    }
}
