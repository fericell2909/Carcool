<template>
  <div class="home">
    <Team msg="Listado de Jugadores"/>
  </div>
</template>

<script>
// @ is an alias to /src
//import HelloWorld from "@/components/HelloWorld.vue";

import Team from "@/components/Team.vue";

export default {
  name: "Home",
  components: {
     Team
  }
};
</script>
