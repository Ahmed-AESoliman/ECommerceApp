import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import SignleProduct from '../views/SignleProduct.vue'
import Checkout from '../views/Checkout.vue'
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/:product',
      name: 'signleProduct',
      component: SignleProduct
    },
    {
      path: '/checkout',
      name: 'checkout',
      component: Checkout
    }
  ]
})

export default router
