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

class UserRegisterService
{
    public static function execute(Request $request)
    {
        try {

            return DB::transaction(function () use ($request) {

                $user = User::create([
                    'user'=> Crypt::encryptString($request['user']),
                    'name' => Crypt::encryptString($request['name']),
                    'phone' => Crypt::encryptString($request['phone']),
                    'password' => Hash::make($request['password'])
                ]);

                $tipoConsentimiento = TipoConsentimiento::where('consentimiento', 'Consent_ID2')->first();
                $identificadorUnico = UniqueKeyService::generate(TipoConsentimientoUser::class);
                $user->tiposConsentimiento()->attach($tipoConsentimiento->id, [
                    'identificador' => $identificadorUnico,
                    'seleccion'=>$request->consent_id2,
                    'estatus'=> true
                ]);
                
                $tipoConsentimiento = TipoConsentimiento::where('consentimiento', 'Consent_ID3')->first();
                $identificadorUnico = UniqueKeyService::generate(TipoConsentimientoUser::class);
                $user->tiposConsentimiento()->attach($tipoConsentimiento->id, [
                    'identificador' => $identificadorUnico,
                    'seleccion'=>$request->consent_id3,
                    'estatus'=> true
                ]);

                return new ApiResponseResource([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Usuario generado correctamente',
                    'data' => [
                        'idUser' => $user->id 
                    ]
                ]);
            }, 3); // reintenta 3 veces si hay deadlock

        } catch (Throwable $e) {

            return new ApiResponseResource([
                'success' => false,
                'code' => 500,
                'message' => 'Ocurrió un error',
                'errors' => [
                    'exception' => $e->getMessage(),
                ]
            ]);
        }
    }
}
