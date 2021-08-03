require('./bootstrap');

window.Vue = require('vue').default;
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
Vue.prototype.$axios = window.axios

import router from './router';
import CssConfig from "./VuetableBootstrap4Config.js";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import App from './Pages/App.vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import Vue from 'vue';
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(FontAwesomeIcon);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    CssConfig,
    el: '#app',
    render: h => h(App)
});
