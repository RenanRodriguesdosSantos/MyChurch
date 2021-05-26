import Vue from 'vue';
import Router from 'vue-router';
import Home from '../components/Home/Home'
import FormMembresia from '../components/membresia/FormMembresia'
import ListarMembresia from '../components/membresia/ListarMembresia';
import FormUsuario from '../components/usuario/FormUsuario';
import ListarUsuario from '../components/usuario/ListarUsuario';
import FormVisitante from '../components/visitante/FormVisitante';
import ListarVisitante from '../components/visitante/ListarVisitante';
import FormEvento from '../components/evento/FormEvento';
import FormCadastroVisita from '../components/visitas/FormCadastroVisita';
import FormVisitar from '../components/visitas/FormVisitar';
import ListarVisitas from '../components/visitas/ListarVisitas';
import ListarEvento from '../components/evento/ListarEvento';
import ChecklistEvento from '../components/evento/ChecklistEvento';
import RelatorioEventos from '../components/relatorios/RelatorioEventos';
<<<<<<< HEAD
import RelatorioMembrosVisitantes from '../components/relatorios/RelatorioMembrosVisitantes';
=======
import BuscarEventosPorteiro from '../components/porteiro/BuscarEventosPorteiro';
>>>>>>> de9a65dc643beeb959b01dd90eb0295fa94e7181

Vue.use(Router);

// Agrupamento de todas as rotas
// Todas as rotas devem ser registradas com nome
// Estes nomes são utilizados no de/para com os itens de menu
const routes = [
  {
    path: '/',
    name: 'home',
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
  {
    path: '/visitante/cadastro',
    name: 'cadastro-visitante',
    component: FormVisitante,
  },
  {
    path: '/visitante/listar',
    name: 'listar-visitante',
    component: ListarVisitante,
  },
  {
    path: '/visitante/editar/:id',
    name: 'editar-visitante',
    component: FormVisitante,
    props: true,
  },
  {
    path: '/evento/cadastro',
    name: 'cadastro-evento',
    component: FormEvento,
  },
  {
    path: '/evento/listar',
    name: 'listar-evento',
    component: ListarEvento,
  },
  {
    path: '/evento/editar/:id',
    name: 'editar-evento',
    component: FormEvento,
    props: true,
  },
  {
    path: '/visita/agenda',
    name: 'agendar-visita',
    component: FormCadastroVisita,
  },
  {
    path: '/visita/editar/:id',
    name: 'editar-visita',
    component: FormCadastroVisita,
    props: true,
  },
  {
    path: '/visita/lista',
    name: 'listar-visitas',
    component: ListarVisitas,
  },
  {
    path: '/visita/realizar/:id',
    name: 'realizar-visita',
    component: FormVisitar,
    props: true
  },
  {
    path: '/evento/:id/checklist',
    name: 'checklist-evento',
    component: ChecklistEvento,
    props: true
  },
  {
    path: '/relatorios/eventos',
    name: 'relatorio-eventos',
    component: RelatorioEventos,
    props: true
  },
  {
<<<<<<< HEAD
    path: '/relatorio/frequencia/membrovisitante/:id',
    name: 'frequencia-membro-visitante',
    component: RelatorioMembrosVisitantes,
=======
    path: '/buscar-eventos',
    name: 'buscar-eventos',
    component: BuscarEventosPorteiro,
>>>>>>> de9a65dc643beeb959b01dd90eb0295fa94e7181
    props: true
  }
];

const router = new Router({
  routes,
  //mode: 'history'
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
