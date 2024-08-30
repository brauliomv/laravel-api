<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
       return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // return [
        //     'name' => 'required',
        //     'age'  => 'required|numeric',
        //     'address' => 'required',
        //     'email' => 'required|unique:students,email,'.$this->id,
        // ];

        $method = $this->method();
        if($method == 'PUT'){
            return [
                'name' => 'required',
                'age'  => 'required|numeric',
                'address' => 'required',
                'email' => 'required|unique:students,email,'.$this->id,
            ];
        }else{
            return [
                'name' => 'sometimes|required',
                'age'  => 'sometimes|required|numeric',
                'address' => 'sometimes|required',
                'email' => 'sometimes|required|unique:students,email,'.$this->id,
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'age.required'  => 'La edad es requerida',
            'age.numeric'  => 'La edad debe ser un tipo de dato numérico',
            'address.required' => 'La dirección es requerida',
            'email.required' => 'El correo electrónico es requerido',
            'email.unique' => 'Este correo eletrónico ya existe' 
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json([
            'message'  => 'Error validando la información',
            'response' => $errors,
            'status'   => 400,
        ],400));
    }
}
