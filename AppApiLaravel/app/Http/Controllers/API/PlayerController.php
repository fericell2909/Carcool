<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use App\Player;
use App\Http\Controllers\Controller as Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PlayerController extends Controller
{

    // Mostrar Datos de Un Jugador Especifico.
    public function show($id = 0)
    {
    

        try
        {
            if($id == 0)
            {

                return $this->response(false, 'Parametro id: Incorrecto', [] ,  []);
            }

            if(trim($id) == "")
            {

                return $this->response(false, 'El Codigo debe de ser numerico', [] ,  [] );
            }

            if(!(is_numeric($id)))
            {

                return $this->response(false, 'El Codigo debe de ser numerico', [] ,  [] );
            }   

            

            $jugador = Player::Listar_Jugador($id);
            

            if (is_null($jugador) || count($jugador) == 0) {
                

                return $this->response(false, 'No se Encontraron Registros del Jugador', [] ,  []);                            

            } else
            {
                if(count($jugador) > 1)
                {

                    
                    return $this->response(false, 'Se encontro mas de un registro por jugador.', [] ,  $jugador);                            
                
                } else
                {                    

                    return $this->response(true, 'Obtencion de Datos Exitoso', [] ,  $jugador);
                  
                }
            }

        }catch(\Exception $e)
        {

            return $this->response(false, 'Ha Ocurrido un Error Inesperado', $e->getMessage() , []);

        }

    }

    // Registrar Jugador.
    public function save(Request $request)
    {

        try{
            $reglas_validacion = [
                //'id' => 'required|numeric|id|unique:mae_jugadores',
                'nombre' => 'required|max:100',
                'posicion' => 'required|max:20',
                'totalgoles' => 'required|numeric',
            ];

            $data_request = $request->all();

            $validator = Validator::make($data_request, $reglas_validacion);

            if ($validator->fails()) {
                    
                return $this->response(false, 'Validacion Incorrecta', $validator->errors() ,  []);
        
            }

            if($data_request['totalgoles'] < 0 )
            {

                return $this->response(false, 'Validacion Incorrecta', array('totalgoles' => 'Debe Ser mayor a cero.') ,  []);
            
            }

            $resultado = false;
            $mensaje_respuesta = "";

            Player::registrar_jugador($data_request['nombre'],$data_request['posicion'],$data_request['totalgoles'] , $resultado ,  $mensaje_respuesta);
            
            if($resultado)
            {

                return $this->response($resultado, $mensaje_respuesta, [] , []);

            } else
            {

                return $this->response($resultado, $mensaje_respuesta, [] , []);
            }


        }catch(\Exception $e)
        {
    
            return $this->response(false, 'Ha Ocurrido un Error Inesperado', $e->getMessage() , []);
    
        }
        

    }

    // Metodo que retorna todos los clubes en los cuales a jugado un jugador
    public function shows_clubes_by_team($id = 0)
    {

        try
        {
            if($id == 0)
            {

                return $this->response(false, 'Parametro id: Incorrecto', [] ,  []);
            }

            if(trim($id) == "")
            {

                return $this->response(false, 'El Codigo debe de ser numerico y No Vacio', [] ,  [] );
            }

            if(!(is_numeric($id)))
            {

                return $this->response(false, 'El Codigo debe de ser numerico', [] ,  [] );
            }   

            

            $data_clubes_by_team = Player::shows_clubes_by_team($id);
            

            if (is_null($data_clubes_by_team) || count($data_clubes_by_team) == 0) {
                

                return $this->response(false, 'No se Encontraron Equipos en los que ha jugado.', [] ,  []);                            

            } else
            {
                
                return $this->response(true, 'Obtencion de Datos Exitoso', [] ,  $data_clubes_by_team);
                  
            }

        }catch(\Exception $e)
        {

            return $this->response(false, 'Ha Ocurrido un Error Inesperado', $e->getMessage() , []);

        }

    }

    private function response($respuesta, $mensaje, $errores , $data)
    {

        return [
            'respuesta' => $respuesta,
            'mensaje' => $mensaje,
            'errores'  => Array('data' => $errores),
            'success' => Array('data' => $data)
        ];

    }
}
