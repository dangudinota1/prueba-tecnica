<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TokenSanctumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permitir la petición (puedes agregar lógica si quieres)
    }

    public function rules(): array
    {
        return [
            'user' => ['required', 'string'],
            'password' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'user.required' => 'El correo es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
