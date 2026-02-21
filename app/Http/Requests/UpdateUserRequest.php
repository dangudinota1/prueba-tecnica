<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }



    public function rules(): array
    {
        return [
            'id_user' => ['required', 'integer', 'min:1'],
            'user' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6'],


            'consent_id2' => ['required', 'boolean'],
            'consent_id3' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_user.required' => 'El campo ID de usuario es obligatorio.',
            'id_user.integer'  => 'El campo ID de usuario debe ser un número entero.',
            'id_user.min'      => 'El campo ID de usuario debe ser mayor a 0.',
            'user.required' => 'El campo user es obligatorio.',
            'name.required' => 'El nombre es obligatorio.',
            'phone.required' => 'El teléfono es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',


            'consent_id2.boolean' => 'El consentimiento 2 debe ser verdadero o falso.',
            'consent_id3.boolean' => 'El consentimiento 3 debe ser verdadero o falso.',
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
