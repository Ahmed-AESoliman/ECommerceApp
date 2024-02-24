<template lang="">
  <div
    class="offcanvas offcanvas-end"
    data-bs-backdrop="static"
    tabindex="-1"
    id="staticBackdrop"
    aria-labelledby="staticBackdropLabel"
    :class="{ show: isOpen }"
  >
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="staticBackdrop">Shopping Cart</h5>
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="offcanvas"
        aria-label="Close"
        @click="closeCart"
      ></button>
    </div>
    <div class="offcanvas-body">
      <div v-for="(item, index) in cart" :key="index" class="mb-2">
        <div class="align-items-center d-flex item-box justify-content-between">
          <div class="img-box">
            <img :src="`${getUlOrigin}/storage/${item.attachment}`" class="w-100" />
          </div>
          <div class="content flex-grow-1 mx-2">
            <h4>{{ item.name }}</h4>
            <span>{{ item.quantity }} x{{ item.price - item.discount }} EGP</span>
          </div>
          <i
            class="bi bi-x"
            style="font-size: 2rem; cursor: pointer"
            @click="removeItem(item.id)"
          ></i>
        </div>
      </div>
      <div class="d-flex justify-content-between align-items-center my-5">
        <div style="color: #857f7f; font-weight: 700">Total</div>
        <div style="font-size: larger; font-weight: 800">{{ total }} EGP</div>
      </div>

      <div class="d-flex flex-column justify-content-between align-items-center">
        <button type="button" @click="checkout" class="btn btn-dark w-100">CHECKOUT</button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'ShoppingCart',
  data() {
    return {
      cart: [],
      total: ''
    }
  },
  props: {
    isOpen: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    checkout() {
      document.querySelector('.btn-close').click()
      this.closeCart()
      this.$router.push('/checkout')
    },
    getCart() {
      this.$http.get(`/api/cart?cart=${this.$cookies.get('cart')}`).then((res) => {
        this.cart = res.data.data.cart
        this.total = res.data.data.total
      })
    },
    closeCart() {
      this.$emit('close-cart')
    },
    removeItem(product) {
      this.$http
        .post(`/api/cart/remove/${product}`, { cart: this.$cookies.get('cart') })
        .then((res) => {
          this.$cookies.set('cart', res.data.data)
          this.getCart()
        })
    }
  },
  watch: {
    isOpen(newVal) {
      if (newVal) {
        this.getCart()
      }
    }
  },
  computed: {
    getUlOrigin() {
      return window.location.origin
    }
  }
}
</script>
<style scope>
.img-box {
  max-width: 70px;
}
.content h4 {
  font-size: larger;
  font-weight: 800;
}
.content span {
  color: #857f7f;
}
</style>
