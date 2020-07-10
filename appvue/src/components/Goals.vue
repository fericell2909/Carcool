<template>
    <div>
        <button  @click="cambiarCantidad" 
                type="button" 
                class="btn btn-primary btn-sm"
                 data-toggle="tooltip" data-placement="left" :title="tooltipsimbolo"
                > {{simbolo}}
        </button>  
    </div>
</template>
<script> 
export default {
    name: "Goals",
    props: ["tipo","cantidad"],
    data(){
        return {  simbolo: '' , tooltipsimbolo : '' }
    },
    methods: {
        cambiarCantidad :  function(){
            let cantidad =  this.cantidad;
            // Agrega   
            if(this.tipo == 1){
                    cantidad = cantidad + 1;
            } else
                {
                    // Disminuye
                    cantidad = cantidad - 1;
                } 

             this.$emit('ActualizandoCantidad', cantidad)

        },
    },
    mounted(){
        if(this.tipo == 1)
        {
            this.simbolo = '+'
            this.tooltipsimbolo = 'Agregar';
        } else
        {
            this.simbolo = '-'
            this.tooltipsimbolo = 'Disminuir';
        }
    }
}
</script>