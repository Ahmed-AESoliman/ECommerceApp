<template>
  <nav class="navbar shadow-sm">
    <div class="container">
      <router-link to="/" class="navbar-brand">
        <span class="logo-box">
          <img src="../assets/img/Logo.png" class="w-100 h-100" />
        </span>
      </router-link>
      <div class="align-items-center d-flex justify-content-end w-75" role="search">
        <div class="flex-fill mx-4">
          <input
            class="form-control form-control-md"
            type="text"
            placeholder="Search"
            aria-label="Search"
          />
        </div>
        <div
          class="cart"
          @click="openCart"
          data-bs-toggle="offcanvas"
          data-bs-target="#staticBackdrop"
          aria-controls="staticBackdrop"
        >
          <i class="bi bi-cart4" style="font-size: 2rem"></i>
        </div>
      </div>
      <shoppingCart :is-open="isOpen" @open-cart="openCart" @close-cart="closeCart" />
    </div>
  </nav>
</template>

<script>
import shoppingCart from './ShoppingCart.vue'

export default {
  name: 'NavBar',
  components: {
    shoppingCart
  },
  data() {
    return {
      isOpen: false
    }
  },
  methods: {
    openCart() {
      this.isOpen = !this.isOpen
    },
    closeCart() {
      this.isOpen = false
    }
  }
}
</script>

<style>
.navbar .cart {
  cursor: pointer;
}
.navbar-brand .logo-box {
  max-width: 65px;
  display: inline-block;
}
</style>
