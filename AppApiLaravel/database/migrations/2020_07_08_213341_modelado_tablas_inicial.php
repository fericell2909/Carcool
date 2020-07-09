<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModeladoTablasInicial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tabla de Estados.
        Schema::create('mae_estados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion',20)->notNullable();
            $table->timestamps();
        });

        DB::table('mae_estados')->insert([
            ['descripcion' => 'Activo'],
            ['descripcion' => 'Inactivo'],
            ]);

        // Fin de Tabla de Estados.
            
         // Tabla de Jugadores
        Schema::create('mae_jugadores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100)->notNullable();
            $table->unsignedInteger('totalgoles')->notNullable()->default(0);
            $table->string('posicion',20)->notNullable()->default('');
            $table->unsignedInteger('estado_id')->notNullable()->default(1);
            $table->foreign('estado_id')->references('id')->on('mae_estados');
            $table->timestamps();
        });

        DB::table('mae_jugadores')->insert([
            
            ['nombre' => 'Marco Estrada Lopez', 'posicion' => 'Arquero'],
            ['nombre' => 'Christian Estrada Lopez', 'posicion' => 'Defensa Central'],
            ['nombre' => 'Franco Estrada Lopez', 'posicion' => 'Defensa Lateral'],
            ['nombre' => 'Manuel Estrada Sifuentes', 'posicion' => 'Mediocampista'],
            ['nombre' => 'Hipolito Estrada Sifuentes', 'posicion' => 'Mediocampista Def.'],  
            ['nombre' => 'Carlos Estrada Sifuentes', 'posicion' => 'Mediocampista Of.'],
            ['nombre' => 'Enrique Garcia Estrada', 'posicion' => 'Delantero Central'],  
            ['nombre' => 'Henry Zavaleta Lopez', 'posicion' => 'Delanterio Extremo'],
            ]);

        // Tabla de Clubes
        Schema::create('mae_clubes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion',100)->notNullable();
            $table->unsignedInteger('estado_id')->notNullable();
            $table->foreign('estado_id')->references('id')->on('mae_estados');
            $table->timestamps();
        });

        DB::table('mae_clubes')->insert([
            ['descripcion' => 'Universitario de Deportes','estado_id' => 1],
            ['descripcion' => 'Alianza Lima','estado_id' => 1],
            ['descripcion' => 'Sporting Cristal','estado_id' => 1],
            ['descripcion' => 'Universidad San Martin','estado_id' => 1],
            ['descripcion' => 'Cienciano del Cusco','estado_id' => 1],
            ['descripcion' => 'Jose Galvez','estado_id' => 1],
            ['descripcion' => 'Real Madrid','estado_id' => 1],
            ['descripcion' => 'Barcelona FC','estado_id' => 1],
            ]);

        // Fin Tabla de Clubes.
            
        // Tabla de Campeonatos.
        Schema::create('mae_campeonatos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion',100)->notNullable();
            $table->unsignedInteger('anio')->notNullable()->unique();
            $table->unsignedInteger('estado_id')->notNullable();
            $table->foreign('estado_id')->references('id')->on('mae_estados');
            $table->timestamps();
        });

        DB::table('mae_campeonatos')->insert([
            ['descripcion' => 'Presidente de la Republica', 'anio' => 2020 ,'estado_id' => 1],
            ['descripcion' => 'Movistar Deportes', 'anio' => 2019 ,'estado_id' => 1],
            ]);
        // Fin Tabla de Campeonatos.

        // Tabla de relacion entre campeonatos_clubes.
        Schema::create('campeonatos_clubes', function (Blueprint $table) {
            
            $table->unsignedInteger('campeonato_id')->notNullable();
            $table->foreign('campeonato_id')->references('id')->on('mae_campeonatos');
            $table->unsignedInteger('clubes_id')->notNullable();
            $table->foreign('clubes_id')->references('id')->on('mae_clubes');
            $table->timestamps();
            $table->unique(['campeonato_id', 'clubes_id']);
        });

        DB::table('campeonatos_clubes')->insert([
            ['campeonato_id' => 1, 'clubes_id' => 1 ],
            ['campeonato_id' => 1, 'clubes_id' => 2 ],
            ['campeonato_id' => 1, 'clubes_id' => 3 ],
            ['campeonato_id' => 1, 'clubes_id' => 4 ],
            ['campeonato_id' => 1, 'clubes_id' => 5 ],
            ['campeonato_id' => 1, 'clubes_id' => 6 ],
            ['campeonato_id' => 1, 'clubes_id' => 7 ],
            ['campeonato_id' => 2, 'clubes_id' => 1 ],
            ['campeonato_id' => 2, 'clubes_id' => 2 ],
            ['campeonato_id' => 2, 'clubes_id' => 3 ],
            ['campeonato_id' => 2, 'clubes_id' => 4 ],
            ['campeonato_id' => 2, 'clubes_id' => 5 ],
            ['campeonato_id' => 2, 'clubes_id' => 6 ],
            ['campeonato_id' => 2, 'clubes_id' => 7 ],
            ]);

        // Fin de Tabla de relacion entre campeonatos_clubes.
        
        // Tabla de relacion entre jugadores_clubes
        Schema::create('jugadores_clubes', function (Blueprint $table) {
            
            $table->unsignedInteger('campeonato_id')->notNullable();
            $table->foreign('campeonato_id')->references('id')->on('mae_campeonatos');
            
            $table->unsignedInteger('clubes_id')->notNullable();
            $table->foreign('clubes_id')->references('id')->on('mae_clubes');
            $table->unsignedInteger('jugador_id')->notNullable();
            $table->foreign('jugador_id')->references('id')->on('mae_jugadores');
            
            $table->timestamps();
        });

        DB::table('jugadores_clubes')->insert([
            ['campeonato_id' => 1, 'clubes_id' => 1,'jugador_id' => 1 ],
            ['campeonato_id' => 1, 'clubes_id' => 2 ,'jugador_id' => 2],
            ['campeonato_id' => 1, 'clubes_id' => 3 ,'jugador_id' => 3],
            ['campeonato_id' => 1, 'clubes_id' => 4 ,'jugador_id' => 8],
            ['campeonato_id' => 1, 'clubes_id' => 5 ,'jugador_id' => 5],
            ['campeonato_id' => 1, 'clubes_id' => 6 ,'jugador_id' => 6],
            ['campeonato_id' => 1, 'clubes_id' => 7 ,'jugador_id' => 7],
            ['campeonato_id' => 2, 'clubes_id' => 1,'jugador_id' =>  2 ],
            ['campeonato_id' => 2, 'clubes_id' => 2 ,'jugador_id' => 1],
            ['campeonato_id' => 2, 'clubes_id' => 3 ,'jugador_id' => 3],
            ['campeonato_id' => 2, 'clubes_id' => 4 ,'jugador_id' => 3],
            ['campeonato_id' => 2, 'clubes_id' => 5 ,'jugador_id' => 8],
            ['campeonato_id' => 2, 'clubes_id' => 6 ,'jugador_id' => 8],
            ['campeonato_id' => 2, 'clubes_id' => 7 ,'jugador_id' => 1],
            ]);
            

        

            /*
        // Tabla de Posiciones
        Schema::create('mae_posiciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion',20)->notNullable();
            $table->unsignedInteger('estado_id')->notNullable();
            $table->foreign('estado_id')->references('id')->on('mae_estados');
            $table->timestamps();
        });

        DB::table('mae_posiciones')->insert([
            ['descripcion' => 'Arquero','estado_id' => 1],
            ['descripcion' => 'Defensa Central','estado_id' => 1],
            ['descripcion' => 'Defensa Lateral','estado_id' => 1],
            ['descripcion' => 'Mediocampista','estado_id' => 1],
            ['descripcion' => 'Mediocampista Of.','estado_id' => 1],
            ['descripcion' => 'Mediocampista Def.','estado_id' => 1],
            ['descripcion' => 'Delantero Extremo','estado_id' => 1],
            ['descripcion' => 'Delantero Central','estado_id' => 1],
            ]);

        // Fin Tabla de Posiciones.
        */


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
