<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreStudentRequest extends FormRequest
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
        return [
            'name' => 'required',
            'age'  => 'required|numeric',
            'address' => 'required',
            'email' => 'required|unique:students'
        ];
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

    //Función para retornar los errores de validación en formato json
    protected function failedValidation(Validator $validator)
    {
        //Se guardan los mensajes de error del validator 
        $errors = $validator->errors();

        //Se lanza un mensaje de error mostrando los mensajes personalizados
        throw new HttpResponseException(response()->json([
            'message' => 'Error validando los datos',
            'errors' => $errors,
            'status' => 400
        ], 400));
    }
}
