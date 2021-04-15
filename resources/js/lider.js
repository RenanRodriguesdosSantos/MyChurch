import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './components/lider/home.vue';
import Lider from './components/lider/index.vue';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: "/lider",
            component: Home
        }
    ]
});

if(document.getElementById("lider")){
    const lider = new Vue({
        router,
        el: '#lider',
        render: h => h(Lider)
    });
}