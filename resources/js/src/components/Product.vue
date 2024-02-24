<template>
  <div
    style="width: 250px"
    class="align-items-center d-flex flex-column justify-content-center p-1"
  >
    <RouterLink :to="`${product.id}`" class="w-100">
      <img class="img-thumbnail" :src="`${getUlOrigin}/storage/${product.attachments}`" />
    </RouterLink>
    <div class="content-box d-flex justify-content-between w-100 align-items-center mt-1">
      <div>
        <h3>{{ product.name }}</h3>
        <p class="lead">{{ product.description }}</p>
      </div>
      <div>
        <div class="price">{{ product.unit_price - product.unit_discount }} EGP</div>
        <div
          class="add-cart align-items-center d-flex justify-content-center shadow"
          @click="addToCart"
        >
          <i class="bi bi-cart-plus-fill" style="font-size: 1.5rem"></i>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Product',
  props: {
    product: Object
  },
  computed: {
    getUlOrigin() {
      return window.location.origin
    }
  },
  methods: {
    addToCart() {
      this.$http
        .post(`/api/cart/add/${this.product.id}`, {
          cart: this.$cookies.get('cart')
        })
        .then((res) => {
          this.$cookies.set('cart', res.data.data, 1)
        })
        .catch((error) => {
          console.log(error)
        })
    }
  }
}
</script>
<style scope>
.content-box {
  color: #000;
}
.content-box .price {
  font-weight: 500;
}
.add-cart {
  width: 45px;
  height: 45px;
  border-radius: 50px;
  cursor: pointer;
}
.img-thumbnail {
  border: 0;
}
</style>
