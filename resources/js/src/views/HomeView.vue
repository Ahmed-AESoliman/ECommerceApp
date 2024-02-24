<template>
  <div>
    <navBar />
    <div class="container">
      <div class="row mt-4">
        <div v-if="products.length === 0" class="w-100 text-center">No Products Found</div>
        <div class="col" v-for="(product, index) in products" :key="index">
          <product :product="product" />
          <!-- Make sure the closing tag is self-closing -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import navBar from '../components/NavBar.vue'
import product from '../components/Product.vue'

export default {
  components: {
    navBar,
    product
  },
  data() {
    return {
      products: []
    }
  },
  methods: {
    refreshProducts() {
      this.$refs.refProducts.refresh()
    },
    fetchProducts(ctx, callback) {
      this.$http
        .get(`/api/product-list`)
        .then((res) => {
          this.products = res.data.data
        })
        .catch((error) => {
          console.error('Error fetching products:', error)
        })
    }
  },
  created() {
    this.fetchProducts()
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
