import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import Index from '../Pages/Products/Index.vue';

const routes = [
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  {path:'/products',component:Index}
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
