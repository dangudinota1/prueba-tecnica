<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }



    public function rules(): array
    {
        return [
            'id_user' => ['required', 'integer', 'min:1'],

        ];
    }

    public function messages(): array
    {
        return [
            'id_user.required' => 'El campo ID de usuario es obligatorio.',
            'id_user.integer'  => 'El campo ID de usuario debe ser un número entero.',
            'id_user.min'      => 'El campo ID de usuario debe ser mayor a 0.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
