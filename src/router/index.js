import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    component: () => import('@/views/HomeView.vue')
  },

  {
    path: '/carrito',
    component: () =>
      import('@/views/CartView.vue')
  },

  {
    path: '/catalogo',
    component: () => import('@/views/CatalogoView.vue')
  },

  {
    path: '/catalogo/:id',
    component: () => import('@/views/ProductoDetalle.vue'),
    props: true
  },

  {
    path: '/login',
    component: () => import('@/views/LoginView.vue')
  },

  {
    path: '/admin',
    component: () => import('@/layouts/AdminLayout.vue'),
    meta: { requiresAuth: true },

    children: [
      {
        path: '',
        component: () => import('@/views/admin/Dashboard.vue')
      },

      {
        path: 'productos',
        component: () => import('@/views/admin/Productos.vue')
      },

      {
        path: 'nuevo',
        component: () => import('@/views/admin/NuevoProducto.vue')
      }
    ]
  },

  {
    path: '/:pathMatch(.*)*',
    component: () => import('@/views/NotFound.vue')
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to) => {
  const autenticado = !!localStorage.getItem('token')
  const requiereAuth = to.matched.some(r => r.meta.requiresAuth)

  if (requiereAuth && !autenticado) {
    return {
      path: '/login',
      query: { redirect: to.fullPath }
    }
  }

  return true
})

export default router