import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import SignleProduct from '../views/SignleProduct.vue'
import Checkout from '../views/Checkout.vue'
import Login from '../views/Login.vue'
import Products from '../views/dashboard/Prodcts.vue'
import Categories from '../views/dashboard/Categories.vue'
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
      },
      {
        path: "/login",
        name: "login",
        component: Login

      },
      {
    path: "/Products",
    name: "products",
    component: Products
      },
      {
          path: "/categories",
          name: "categories",
          component:Categories
      }
  ]
})

export default router
