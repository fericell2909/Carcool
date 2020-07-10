<template>
  <div class="hello">
    <b-alert show variant="primary">{{msg}}</b-alert>
  </div>
</template>

<script>

export default {
  name: "HelloWorld",
  props: {
    msg: String
  }
};
  </script>

