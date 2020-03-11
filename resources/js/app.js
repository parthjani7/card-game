import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./routes.js";
import App from "./views/App";
import _ from "lodash";
import axios from "axios";
import { BootstrapVue } from "bootstrap-vue";

Vue.use(VueRouter);
Vue.use(BootstrapVue);

Vue.prototype.$axios = axios;
Vue.prototype.$_ = _;

const router = new VueRouter({
    mode: "history",
    routes // short for `routes: routes`
});

export default new Vue({
    router,
    render: h => h(App)
}).$mount("#app");
