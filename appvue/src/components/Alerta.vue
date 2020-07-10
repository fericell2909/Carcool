<template><div></div></template>
<script>
export default {
    name: "Alerta",
    methods: {
      mostraralerta : function (mensaje)
      {
        Swal.fire(mensaje);
      },
    },
};
</script>
