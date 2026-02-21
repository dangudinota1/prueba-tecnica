<?php

namespace App\Services\Users;

use App\Models\User;
use App\Http\Resources\ApiResponseResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Facades\Crypt;
use App\Models\TipoConsentimiento;
use App\Models\TipoConsentimientoUser;
use App\Services\Key\UniqueKeyService;

class UserUpdateService
{
    /**
     * Actualiza los datos de un usuario existente y sus consentimientos
     */
    public static function execute(Request $request)
    {
        try {

            return DB::transaction(function () use ($request) {

                $user = User::findOrFail($request->id_user);

                // Actualizar datos del usuario
                $user->update([
                    'user' => Crypt::encryptString($request['user']),
                    'name' => Crypt::encryptString($request['name']),
                    'phone' => Crypt::encryptString($request['phone']),
                    'password' => Hash::make($request['password']),
                ]);

                // Actualizar consentimientos dinámicamente
                $consentimientos = [
                    'Consent_ID2' => $request->consent_id2 ?? null,
                    'Consent_ID3' => $request->consent_id3 ?? null,
                ];

                foreach ($consentimientos as $consentName => $seleccion) {
                    $tipoConsentimiento = TipoConsentimiento::where('consentimiento', $consentName)->first();

                    if ($tipoConsentimiento) {
                        $identificadorUnico = UniqueKeyService::generate(TipoConsentimientoUser::class);

                        // Actualiza o inserta el registro en la tabla pivote
                        $user->tiposConsentimiento()->syncWithoutDetaching([
                            $tipoConsentimiento->id => [
                                'estatus' => false
                            ]
                        ]);

                        $user->tiposConsentimiento()->attach($tipoConsentimiento->id, [
                            'identificador' => $identificadorUnico,
                            'seleccion' => $seleccion,
                            'estatus' => true
                        ]);
                    }
                }

                return new ApiResponseResource([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Usuario actualizado correctamente',
                    'data' => [
                        'idUser' => $user->id
                    ]
                ]);
            }, 3); // Reintenta 3 veces si hay deadlock

        } catch (Throwable $e) {

            return new ApiResponseResource([
                'success' => false,
                'code' => 500,
                'message' => 'Ocurrió un error al actualizar el usuario',
                'errors' => [
                    'exception' => $e->getMessage(),
                ]
            ]);
        }
    }
}
