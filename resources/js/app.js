import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./routes.js";
import App from "./views/App";
import _ from "lodash";
import axios from "axios";
import { BootstrapVue } from "bootstrap-vue";

import { ValidationObserver, ValidationProvider, extend } from "vee-validate";
import * as rules from "vee-validate/dist/rules";

// Install VeeValidate rules and localization
Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});

// Install VeeValidate components globally
Vue.component("ValidationObserver", ValidationObserver);
Vue.component("ValidationProvider", ValidationProvider);

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
