import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './components/obreiro/home.vue';
import Obreiro from './components/obreiro/index.vue';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: "/obreiro",
            component: Home
        }
    ]
});

if(document.getElementById("obreiro")){
    const obreiro = new Vue({
        router,
        el: '#obreiro',
        render: h => h(Obreiro)
    });
}
