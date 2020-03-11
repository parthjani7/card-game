import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./routes.js";
import App from "./views/App";
import _ from "lodash";
import axios from "axios";

Vue.use(VueRouter);
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
