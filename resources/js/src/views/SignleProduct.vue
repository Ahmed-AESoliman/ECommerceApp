<template>
  <div>
    <navBar></navBar>
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-md-6 col-lg-7">
          <Carousel :autoplay="2000" :wrap-around="true" class="carousel__item">
            <Slide v-for="slide in product.attachments" :key="slide">
              <img class="carousel__item" :src="`${getUlOrigin}/storage/${slide}`" />
            </Slide>
          </Carousel>
        </div>
        <div class="col-12 col-md-6 col-lg-5">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Home</li>
              <li class="breadcrumb-item">{{ product.category }}</li>
              <li class="breadcrumb-item active" aria-current="page">{{ product.sub_category }}</li>
            </ol>
          </nav>
          <div>
            <div className="ProductTitleName">
              <h2>{{ product.name }}</h2>
            </div>
            <div className="ProductPrice">
              <h2>{{ product.unit_price - product.unit_discount }} EGP</h2>
            </div>
            <div className="ProductDesc">
              <p>{{ product.description }}</p>
            </div>
            <div class="checkoutCounter">
              <button @click="handleDecrement">-</button>
              <span readOnly>{{ count }}</span>
              <button @click="handleIncrement">+</button>
            </div>
            <div className="ProductDetailsBtns">
              <Router-Link to="/" className="ShopNowBtn"> SHOP NOW </Router-Link>
              <button className="AddToCartBtn" @click="updateCart">ADD TO CART</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import navBar from '../components/NavBar.vue'
import { Carousel, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

export default {
  components: {
    navBar,
    Carousel,
    Slide
  },
  data() {
    return {
      count: 0,
      product: []
    }
  },
  computed: {
    productId() {
      return this.$route.params.product
    },
    getUlOrigin() {
      return window.location.origin
    }
  },
  methods: {
    handleIncrement() {
      this.count += 1
    },
    handleDecrement() {
      if (this.count > 1) {
        this.count -= 1
      }
    },
    fetchProduct() {
      this.$http
        .get(`/api/product-show/${this.productId}`)
        .then((res) => {
          this.product = res.data.data
          if (this.$cookies.get('cart')) {
            let cart = JSON.parse(this.$cookies.get('cart'))
            if (cart && cart[this.productId]) {
              this.count = cart[this.productId].quantity
            }
          }
        })
        .catch((error) => {
          this.$router.push('/')
        })
    },
    updateCart() {
      this.$http
        .post(`/api/cart/update/${this.productId}`, {
          cart: this.$cookies.get('cart'),
          quantity: this.count
        })
        .then((res) => {
          this.$cookies.set('cart', res.data.data)
        })
    }
  },
  created() {
    this.fetchProduct()
  }
}
</script>

<style scope>
.carousel__item {
  min-height: 300px;
  width: 100%;
  border-radius: 8px;
  background-color: aquamarine;
}
.ProductTitleName h2 {
  font-size: 20px;
  color: #000000;
  font-weight: 700;
  margin-top: 24px;
  margin-bottom: 16px;
}
.ProductPrice h2 {
  font-size: 20px;
  color: #9c9c9c;
  font-weight: 700;
  margin-bottom: 20px;
}
.ProductDesc p {
  font-size: 12px;
  color: #9c9c9c;
  font-weight: 400;
  margin-bottom: 24px;
  width: 80%;
}
.checkoutCounter {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border: 1px solid #9c9c9c;
  width: 94px;
  height: 40px;
  padding: 0.5rem;
  border-radius: 4px;
}
.checkoutCounter button {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border: none;
  background-color: transparent;
}
.ProductDetailsBtns {
  display: flex;
  margin-top: 32px;
}
.ProductDetailsBtns .ShopNowBtn {
  width: 156px;
  height: 40px;
  background-color: #000000;
  border-radius: 6px;
  color: #ffffff;
  font-size: 16px;
  font-weight: 600;
  text-decoration: none;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-right: 12px;
}
.ProductDetailsBtns .AddToCartBtn {
  width: 156px;
  height: 40px;
  background-color: #000000;
  border-radius: 6px;
  color: #ffffff;
  font-size: 16px;
  font-weight: 600;
  text-decoration: none;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
