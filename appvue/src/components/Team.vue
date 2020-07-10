<template>
  <div class="container">    
    <table class="table table-stripped table-hover">
            <thead>
            <tr class="busqueda-caja">
              <th colspan = "4">
              <label for="">Criterio de Busqueda</label>
                  <input type="text" class="form-control text-center" 
                   placeholder="Busqueda por Nombre o Posicion" v-model="busquedaconsulta"/>
              </th>
            </tr>
              <tr>
                <th>Apellidos y Nombres</th>
                <th >Posicion de Juego</th>
                <th class="text-center"># Goles</th>
                <th >Acciones</th>                
              </tr>
            </thead>
            <tbody>
              <tr class="text-center">
                <td>
                    <input type="text" class="form-control text-center" 
                    v-model="NuevoRegistro.nombre" placeholder="Ingrese Apellidos y Nombres" />
                </td>
                <td>
                    <input type="text" class="form-control text-center" v-model="NuevoRegistro.posicion" placeholder="Ingrese Posicion" />
                </td>
                <td >
                    <div class="row ">
                        <div class="ml-5"></div>
                        <Goals :cantidad="NuevoRegistro.cantidadgoles" tipo="1" id="0" @click="cambiarCantidad()"
                        @ActualizandoCantidad="ActualizandoCantidad" class="mr-1">
                        </Goals>
                      <label class="label label-primary">{{NuevoRegistro.cantidadgoles}}</label>       
                      <Goals :cantidad="NuevoRegistro.cantidadgoles" tipo="2" @click="cambiarCantidad()" 
                          @ActualizandoCantidad="ActualizandoCantidad" id="0" class="ml-1">
                      </Goals>
                    </div> 
                </td>
                <td>
                    <button @click="agregar()" type="button" class="btn btn-success btn-sm"><b-icon icon="bookmark-plus"></b-icon>&nbsp;Agregar</button>
                </td>  
              </tr>
              <tr v-if="items.length === 0">
                <td colspan="4" class="text-center">
                  No hay registros por mostrar
                </td>
              </tr>
              <tr v-for="item in items" v-bind:key="item.id">
                <th scope="row" v-show="false">{{ item.id }}</th>
                <td>
                    <span v-if="flagactualizar && EditarRegistro.id == item.id">
                          <input v-model="EditarRegistro.nombre"  type="text" class="form-control">
                            </span>
                      <span v-else>
                                {{ item.nombre }}
                    </span>

                </td>
                <td>
                    <span v-if="flagactualizar && EditarRegistro.id == item.id">
                          <input v-model="EditarRegistro.posicion" type="text" class="form-control">
                            </span>
                      <span v-else>
                                {{ item.posicion }}
                    </span>

                </td>
                <td>
                    <div class="row">
                      <div class="ml-5"></div>
                        <Goals  :cantidad="item.cantidadgoles" tipo="1" @click="cambiarCantidad()"
                        @ActualizandoCantidadItem="ActualizandoCantidadItem" :id="item.id" class="mr-1">
                        </Goals>
                    <label class="label label-primary" >{{item.cantidadgoles}}</label>       
                    <Goals :cantidad="item.cantidadgoles" tipo="2"  @click="cambiarCantidad()" 
                        @ActualizandoCantidadItem="ActualizandoCantidadItem" :id="item.id" class="ml-1">
                    </Goals>
                    </div>

                    </td>
                <td class="text-center">
                      <span v-if="flagactualizar && EditarRegistro.id == item.id">
                          <button @click="guardarEdicionGrilla(item)" class="btn btn-success btn-sm mr-1"><b-icon icon="exclude"></b-icon>&nbsp;Guardar</button>
                          <button @click="CancelarEdicionGrilla(item)" type="button" class="btn btn-warning btn-sm"><b-icon icon="chevron-double-left"></b-icon>&nbsp;Cancelar</button>
                    </span>
                    <span v-else>
                      <button @click="editar(item)" type="button" class="btn btn-primary btn-sm mr-1"><b-icon icon="pencil-square"></b-icon>&nbsp;Editar</button>
                      <button @click="eliminar(item)" type="button" class="btn btn-danger btn-sm"><b-icon icon="trash"></b-icon>&nbsp;Eliminar</button>
                    </span>
                </td>
           </tr>
            </tbody>
    </table>
    <alerta ref='componentealerta'></alerta>
    </div>
</template>
<style>
.busqueda-caja {
    background: #c1c1c1;
    border: 1px solid #ababab;
    padding: 3%;
}
</style>

<script>

// Carga de Datos por medio de archivo Json. Nombre de Archivo : data.json;

import datos from "../constants/data.json"
import Goals from '../components/Goals'
import Alerta from '../components/Alerta'

export default {
  name: "Team", 
  props: {
    msg: String,
  },
  components : {
      Goals , Alerta
  },
  data() {
      return {
          NuevoRegistro : {
                        nombre: '',
                        posicion: '',
                        cantidadgoles : 0
                        },   
          EditarRegistro : {
              id : 0,
              nombre: '',
              posicion: '',
              cantidadgoles : 0
          },               
        flagactualizar : false,
        poblacion : [] ,
        mensajealerta : '',
        busquedaconsulta : '',
      }
    },
    computed: {
      items :  function () 
      {
 
        if(this.busquedaconsulta ){
            return this.poblacion.filter((item)=>{
              return item.nombre.startsWith(this.busquedaconsulta) || item.posicion.startsWith(this.busquedaconsulta) ;
            })
            }else{
              return this.poblacion;
            }
      },
    },
   created() {
       this.leer();
       this.obtenerposiciones();
   },
    methods: {
         leer() {
             return datos.map((item) => {
                  return this.poblacion.push(item);
             }); 
        },
        obtenerposiciones : function(){
              //return this.poblacion.filter((x, i, a) => a.indexOf(x) == i);
            //console.log('Entramos');
           // console.log(this.poblacion);
              var hash = {};
                let array = this.poblacion.filter(function(current) {
                  var exists = !hash[current.posicion];
                  hash[current.posicion] = true;
                  return exists;
                });

              this.puestos = array;
          },

        editar : function(item){
            
            this.EditarRegistro.id = item.id
            this.EditarRegistro.nombre = item.nombre;
            this.EditarRegistro.posicion = item.posicion;
            this.flagactualizar = true;

        },
        CancelarEdicionGrilla : function(item)
        {
          this.flagactualizar = false;
          this.EditarRegistro.id = 0;
          this.EditarRegistro.nombre = "";
          this.EditarRegistro.posicion = "";

        },
        guardarEdicionGrilla : function(item) {
          
          let actualizacion =  false; 

          let posicion = this.EditarRegistro.posicion;
          let nombre = this.EditarRegistro.nombre;

          if( nombre.trim() == '')
            {
              this.$refs.componentealerta.mostraralerta('Debe Ingresar un Nombre');
              return;
            }

             if( posicion.trim() == '')
            {
              this.$refs.componentealerta.mostraralerta('Debe Ingresar una Posicion');
              return;
            }



          this.poblacion.forEach(function(elemento, index) {
              
             if(elemento.id == item.id)
             {
               
                elemento.posicion = posicion;
                elemento.nombre = nombre;
                actualizacion = true;
            }
          }
          );
          if(actualizacion)
          {
              this.CancelarEdicionGrilla(null);
              this.$refs.componentealerta.mostraralerta('Se Editaron los Datos Correctamente');
          }
        },
        eliminar : function(item) {
            
            this.poblacion.splice(item, 1);
            this.$refs.componentealerta.mostraralerta('Se elimino el registro correctamente');

        },
        agregar() {

            if(this.NuevoRegistro.nombre.trim() == '')
            {
              this.$refs.componentealerta.mostraralerta('Debe Ingresar un Nombre');
              return;
            }

             if(this.NuevoRegistro.posicion.trim() == '')
            {
              this.$refs.componentealerta.mostraralerta('Debe Ingresar una Posicion');
              return;
            }

            if(this.NuevoRegistro.cantidadgoles <= 0)
            {
              this.$refs.componentealerta.mostraralerta('La Cantidad de Goles Debe ser Mayor a Cero.');
              return;
            }
            
            
            let id = 0;
            if(this.poblacion.length > 0 )
            {
              id = this.poblacion.length;
            } else
            {
              id = 1;
            }
            this.poblacion.push({
            id: id,
            nombre: this.NuevoRegistro.nombre,
            posicion: this.NuevoRegistro.posicion,
            cantidadgoles: this.NuevoRegistro.cantidadgoles
          });

          this.$refs.componentealerta.mostraralerta('Se Agrgo el Nuevo Jugador Correctamente');

        },
        ActualizandoCantidad : function(newvalue){
                this.NuevoRegistro.cantidadgoles = newvalue;
        },
        ActualizandoCantidadItem : function(item)
        {

          this.poblacion.forEach(function(elemento, index) {
              
             if(elemento.id === item.id)
             {
                elemento.cantidadgoles = item.cantidadgoles;
             }
          });

        }
    },
}
  </script>