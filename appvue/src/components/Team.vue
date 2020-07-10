<template>
  <div class="container">
    <table class="table table-stripped table-hover">
            <thead>
              <tr>
                <th>Apellidos y Nombres</th>
                <th >Posicion de Juego</th>
                <th ># Goles</th>
                <th >Acciones</th>                
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                    <input type="text" class="form-control text-center" v-model="NuevoRegistro.name" placeholder="Ingrese Apellidos y Nombres" />
                </td>
                <td>
                    <input type="text" class="form-control text-center" v-model="NuevoRegistro.posicion" placeholder="Ingrese Posicion" />
                </td>
                <td>
                    <div class="row">
                        <Goals :cantidad="NuevoRegistro.cantidadgoles" tipo="1" @click="cambiarCantidad()"
                        @ActualizandoCantidad="ActualizandoCantidad" class="mr-1">
                    </Goals>

                    <label class="label label-primary">{{NuevoRegistro.cantidadgoles}}</label>       
                    <Goals :cantidad="NuevoRegistro.cantidadgoles" tipo="2" @click="cambiarCantidad()" 
                        @ActualizandoCantidad="ActualizandoCantidad" class="ml-1">
                    </Goals>
                    </div> 
                </td>
                <td>
                    <button @click="agregar()" type="button" class="btn btn-success btn-sm"><b-icon icon="bookmark-plus"></b-icon>&nbsp;Agregar</button>
                </td>  
              </tr>
              <tr v-for="item in items" v-bind:key="item.id">
                <th scope="row" v-show="false">{{ item.id }}</th>
                <td>{{ item.nombre }}</td>
                <td>{{ item.posicion }}</td>
                <td><Goals cantidad="0" tipo="1"
                         @ActualizandoCantidad="ActualizandoCantidad"
                     ></Goals>
                    {{ item.totalgoles }}<Goals tipo="2" Cantidad ="0"></Goals></td>
                <td class="text-center">
                    <button @click="editar()" type="button" class="btn btn-primary btn-sm mr-1"><b-icon icon="pencil-square"></b-icon>&nbsp;Editar</button>
                    <button @click="eliminar(item)" type="button" class="btn btn-danger btn-sm"><b-icon icon="trash"></b-icon>&nbsp;Eliminar</button>
                </td>
           </tr>
            </tbody>
    </table>
    </div>
</template>


<script>

// Carga de Datos por medio de archivo Json. Nombre de Archivo : data.json;

import datos from "../constants/data.json"
import Goals from '../components/Goals'

export default {
  name: "Team", 
  props: {
    msg: String,
  },
  components : {
      Goals
  },
  data() {
      return {
          NuevoRegistro : {
                        nombre: '',
                        posicion: '',
                        cantidadgoles : 0
                        },
        poblacion : [] ,
      }
    },
    computed: {
      items :  function () 
      {
        return this.poblacion;
      }
    },
   created() {
       this.leer();
   },
    methods: {
        async leer() {
             return datos.map((item) => {
                  return this.poblacion.push(item);
             }); 
        },
        eliminar : function(item) {
            
            this.poblacion.splice(item, 1);

        },
        agregar() {

            if(this.NuevoRegistro.nombre === '')
            {
                
                return false;
            }

            let id =  this.poblacion.length > 0 ? this.poblacion.length : 1;
            this.poblacion.push({
            id: id,
            nombre: this.NuevoRegistro.nombre,
            posicion: this.NuevoRegistro.posicion,
            cantidadgoles: this.NuevoRegistro.cantidadgoles
          });
        },
        ActualizandoCantidad : function(newvalue){

                this.NuevoRegistro.cantidadgoles = newvalue;
        }
    },
}
  </script>