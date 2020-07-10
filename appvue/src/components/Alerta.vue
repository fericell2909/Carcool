<template>
  <div>
    <h1>
        {{msg1}}
    </h1>
  </div>
</template>
<script>
export default {
    name: "Alerta",
    props: ['msg1'],
  methods: {
    MostrarAlerta(texto) {
        this.msg1 = texto;
    }

  },
}
</script>
