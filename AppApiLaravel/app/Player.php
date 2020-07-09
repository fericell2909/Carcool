<?php

namespace App;

use Illuminate\Support\Facades\DB as DB;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'mae_jugadores';
    public $primarykey = 'id';
    
    protected $fillable = [
        'nombre', 'totalgoles','posicion'
    ];

    static public  function Listar_Jugador($id){


        return Player::where("id","=",$id)->select('id','nombre','posicion','totalgoles')->get();


    }

    static public function registrar_jugador($nombre,$posicion,$totalgoles , & $resultado , & $mensaje_respuesta)
    {   
        
            $jugador = new Player();
            $jugador->nombre = $nombre;
            $jugador->totalgoles  = $totalgoles;
            $jugador->posicion = $posicion;
            
            if($jugador->save()) {
                $resultado = true;
                $mensaje_respuesta = "Se Registro al Jugador : ".$nombre . " exitosamente";
                
            } else
            {
                $resultado = true;
                $mensaje_respuesta = "No se pudo registrar al jugador. Comuniquese con Soporte.";
            }
    }

    static public function shows_clubes_by_team($id)
    {

        return Player::select(DB::raw("distinct cl.clubes_id as codigoclub ,
                                      club.descripcion AS nombreclub"))
                         ->join('jugadores_clubes AS cl','cl.jugador_id','=', 'mae_jugadores.id')
                         ->join('mae_clubes AS club','club.id','=', 'cl.clubes_id')
                        ->where('mae_jugadores.id',$id)->get();
                                 
    }

}
