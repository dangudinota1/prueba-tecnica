<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ApiResponseResource;
use App\Models\TipoConsentimiento;
use App\Models\User;
use App\Services\Users\UserDeleteService;
use App\Services\Users\UserRegisterService;
use App\Services\Users\UserUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Crypt;
use DB;

class UsersController extends Controller
{
    //
    public function crearUsuario(RegisterUserRequest $request)
    {

            $resultado=UserRegisterService::execute($request);
            return $resultado;
  
    }


    public function actualizarUsuario(UpdateUserRequest $request)
    {

            $resultado=UserUpdateService::execute($request);
            return $resultado;
  
    }

    public function eliminarUsuario(DeleteUserRequest $request)
    {

            $resultado=UserDeleteService::execute($request);
            return $resultado;
  
    }
}
