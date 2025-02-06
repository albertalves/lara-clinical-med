<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDoctorRequest extends FormRequest
{
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
            'name' => 'required|max:100',
            'specialty' => 'required|max:100',
            'cityId' => 'required|exists:cities,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O campo nome deve ter menos de :max caracteres',
            'specialty.required' => 'O campo especialidade é obrigatório.',
            'specialty.max' => 'O campo especialidade deve ter menos de :max caracteres',
            'cityId.required' => 'O campo cityId é obrigatório.',
            'cityId.exists' => 'Esta cidade não existe, informe um cityId válido.',
        ];
    }
}
