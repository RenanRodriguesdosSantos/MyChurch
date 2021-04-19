import Vue from 'vue';
import Router from 'vue-router';
import Home from '../components/Home/Home'
import FormMembresia from '../components/membresia/FormMembresia'
import ListarMembresia from '../components/membresia/ListarMembresia';

Vue.use(Router);

// Agrupamento de todas as rotas
// Todas as rotas devem ser registradas com nome
// Estes nomes são utilizados no de/para com os itens de menu
const routes = [
  {
    path: '/',
    name: '/',
    component: Home,
  },
  {
    path: '/membresia/cadastro',
    name: 'cadastro-membresia',
    component: FormMembresia,
  },
  {
    path: '/membresia/editar/:id',
    name: 'editar-membresia',
    component: FormMembresia,
    props: true,
  },
  {
    path: '/membresia/listar',
    name: 'listar-membresia',
    component: ListarMembresia,
  },
];

const router = new Router({
  routes,
});

// // em todas as rotas é verificado autenticação e autorização
// router.beforeEach((to, from, next) => {
//   // funções para mover o scroll para o inicio da tela
//   window.scrollTo(0, 0);
//   window.scrollTo({ x: 0, y: 0 });
//   document.body.scrollTop = 0;
//   authenticationGuard(to, from, next);
//   // authorizationGuard(to, from, next);
// });

export default router;
