import Vue from 'vue'
import vuetify from './vuetify';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-default.css';

window.Vue = Vue;
import inject from './VueInstanceInject';
require('./bootstrap');
Vue.component('main-component', require('./components/Home/Main.vue').default);

Vue.use(VueToast, {
    // One of the options
    position: 'top-right',
    pauseOnHover: true
});

const app = new Vue({
    el: '#app',
    ...inject,
    vuetify
});
