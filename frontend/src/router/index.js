import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import NaoEncontrada from '../views/NaoEncontrada.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/listarcadastro',
    name: 'ListarCadastro',
    component: () => import('../views/ListarCadastro.vue')
  },
  {
    path: '/:catchAll(.*)',
    name: 'NaoEncontrada',
    component: NaoEncontrada
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
