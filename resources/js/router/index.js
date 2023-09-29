import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'index',
      component: () => import('../views/main.vue')
    },
      {
      path: '/create',
      name: 'create',
      component: () => import('../views/make.vue')
    },
  ]
})

export default router
