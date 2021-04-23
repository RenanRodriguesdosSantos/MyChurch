import Vue from 'vue';
import Router from 'vue-router';
import Home from '../components/Home/Home'
import FormMembresia from '../components/membresia/FormMembresia'
import ListarMembresia from '../components/membresia/ListarMembresia';
import FormUsuario from '../components/usuario/FormUsuario';
import ListarUsuario from '../components/usuario/ListarUsuario';

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
  {
    path: '/usuario/cadastro',
    name: 'cadastro-usuario',
    component: FormUsuario,
  },
  {
    path: '/usuario/editar/:id',
    name: 'editar-usuario',
    component: FormUsuario,
    props: true,
  },
  {
    path: '/usuario/listar',
    name: 'listar-usuario',
    component: ListarUsuario,
  },
];

const router = new Router({
  routes,
  mode: 'history'
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
