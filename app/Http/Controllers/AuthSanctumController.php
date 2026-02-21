<?php

namespace App\Http\Controllers;

use App\Http\Requests\TokenSanctumRequest;
use App\Http\Resources\ApiResponseResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;


class AuthSanctumController extends Controller
{
    //


    public function token(TokenSanctumRequest $request)
    {
        try {
            //code...
            $user = User::where('name', $request->user)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {

                return response()->json([
                    'success' => false,
                    'message' => 'Las credenciales son incorrectas.'
                ], 401);
            }
            $fecha_expiracion = Carbon::now()->addMinutes(5);

            return new ApiResponseResource([
                'success' => true,
                'code' => 200,
                'message' => 'Token generado correctamente',
                'data' => [
                    'Token' => $user->createToken(
                        'token-name',
                        ['*'],
                        now()->addMinutes(5)
                    )->plainTextToken,
                    'Date_Finish' => $fecha_expiracion
                ]
            ]);
            return;
        } catch (\Throwable $th) {
            return new ApiResponseResource([
                'success' => false,
                'code' => 500,
                'message' => 'Ocurrió un error',
                'errors' => [
                    'exception' => $th->getMessage(),
                ]
            ]);
        }
    }
}
