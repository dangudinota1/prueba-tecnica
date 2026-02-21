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

class UserDeleteService
{
    /**
     * Actualiza los datos de un usuario existente y sus consentimientos
     */
    public static function execute(Request $request)
    {
        try {

            return DB::transaction(function () use ($request) {
                //dd($request->all());
                $user = User::find($request->id_user);

                if (!$user) {
                    return new ApiResponseResource([
                        'success' => false,
                        'code' => 404,
                        'message' => 'Usuario no encontrado',
                        'data' => null,
                        'errors' => ['user' => 'No existe un usuario con ese ID']
                    ]);
                }
                // Eliminar relaciones pivote
                $user->tiposConsentimiento()->detach();

                // Eliminar usuario
                $user->delete();
                

                return new ApiResponseResource([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Usuario eliminado correctamente'
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
