<?php


namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\User;
use Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RegisterController extends Controller
{

    public function register(Request $request)
    {
        $reglas_validacion = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ];

        try {
             
            $validator = Validator::make($request->all(), $reglas_validacion );


            if($validator->fails()){
                return [
                    'respuesta' => false,
                    'mensaje' => 'Validacion Incorrecta',
                    'errores'  => $validator->errors(),
                    'success' => []
                ];
            }


            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            
            $user = User::create($input);
            $response['token'] =  $user->createToken('laraRestApi')->accessToken;
            $response['name'] =  $user->name;
            $response['success'] = true;
            $response['message'] = "Usuario Registrado Correctamente.";

            return [
                'respuesta' => true,
                'errores'  => [],
                'success' => $response
            ];
           
        }catch(\Exception $e)
        {

            return [
                'respuesta' => false,
                'errores'  =>['mensaje' => $e->getMessage()] ,
                'success' => []
            ];

        }


    }
}