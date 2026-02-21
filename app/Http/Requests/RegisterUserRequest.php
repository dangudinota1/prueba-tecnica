<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Forzar Consent_ID1 a true si no viene en la petición
        $this->merge([
            'consent_id1' => true,
        ]);
    }

    public function rules(): array
    {
        return [
            'user' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6'],

            'consent_id1' => ['required', 'boolean', 'accepted'], // debe ser true
            'consent_id2' => ['required', 'boolean'],
            'consent_id3' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'user.required' => 'El campo user es obligatorio.',
            'name.required' => 'El nombre es obligatorio.',
            'phone.required' => 'El teléfono es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',

            'consent_id1.accepted' => 'Debe aceptar el consentimiento 1.',
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
