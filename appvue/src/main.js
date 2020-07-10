import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import "bootstrap/dist/css/bootstrap.css"
import "bootstrap-vue/dist/bootstrap-vue.css"
import "bootstrap-vue/dist/bootstrap-vue-icons.min.css"
import { BootstrapVue, BootstrapVueIcons } from "bootstrap-vue"


//import VueSweetalert2 from 'vue-sweetalert2'; 

Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)

//Vue.use(VueSweetalert2);

Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
