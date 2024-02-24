<template lang="">
  <div>
    <navBar></navBar>
    <div class="container pb-5">
      <div class="row">
        <div class="col-12">
          <h2>Shopping Cart</h2>
          <div class="table-responsive">
            <table class="table align-middle">
              <thead class="table-light">
                <tr>
                  <th scope="col">Product</th>
                  <th scope="col">Price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Total</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in cart" :key="index">
                  <th scope="row">
                    <div class="productTableInfo">
                      <img
                        :src="`${getUlOrigin}/storage/${item.attachment}`"
                        alt=""
                        class="w-100"
                      />
                      <h4>{{ item.name }}</h4>
                    </div>
                  </th>
                  <td>
                    <p>{{ item.price - item.discount }} EGP</p>
                  </td>
                  <td>
                    <div class="checkoutCounter">
                      <button type="button" @click="handleDecrement(item.id)">-</button>
                      <span>{{ itemCounts[item.id] }}</span>
                      <button type="button" @click="handleIncrement(item.id)">+</button>
                    </div>
                  </td>
                  <td>
                    <p>{{ item.total }} EGP</p>
                  </td>
                  <td>
                    <button
                      type="button"
                      style="border: none; background-color: transparent"
                      @click="removeItem(item.id)"
                    >
                      <i class="bi bi-trash-fill" style="color: red"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="totalAmount">
            <h4>Total:</h4>
            <h2>{{ total }} EGP</h2>
          </div>
        </div>
        <div class="col-12">
          <Form @submit="onSubmit">
            <div class="row">
              <h2>Customer Details</h2>
              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <label class="form-label">Name</label>
                  <Field
                    name="customer_name"
                    type="text"
                    :rules="isRequired"
                    placeholder="ahmed soliman"
                    class="form-control"
                  />
                  <ErrorMessage name="customer_name" />
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <label class="form-label">Email address</label>
                  <Field
                    name="customer_email"
                    type="email"
                    :rules="validateEmail"
                    class="form-control"
                  />
                  <ErrorMessage name="customer_email" />
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <label class="form-label">Phone</label>
                  <Field
                    name="customer_phone"
                    type="text"
                    :rules="isRequired"
                    class="form-control"
                    placeholder="01112005445"
                  />
                  <ErrorMessage name="customer_phone" />
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <label class="form-label">Adress</label>
                  <Field
                    name="customer_address"
                    type="text"
                    :rules="isRequired"
                    placeholder="Maadi"
                    class="form-control"
                  />
                  <ErrorMessage name="customer_address" />
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <label class="form-label">City</label>
                  <Field
                    name="customer_city"
                    type="text"
                    :rules="isRequired"
                    placeholder="cairo"
                    class="form-control"
                  />
                  <ErrorMessage name="customer_city" />
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="mb-3">
                  <label class="form-label">Country</label>
                  <Field
                    name="customer_country"
                    type="text"
                    :rules="isRequired"
                    placeholder="egypt"
                    class="form-control"
                  />
                  <ErrorMessage name="customer_country" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="CheckoutBtns">
                  <router-link to="/" class="contShoppingBtn">CONTINUE SHOPPING</router-link>
                  <button class="CheckoutBtn">Checkout</button>
                </div>
              </div>
            </div>
          </Form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import navBar from '../components/NavBar.vue'
import { Field, Form, ErrorMessage } from 'vee-validate'

export default {
  components: {
    navBar,
    Form,
    ErrorMessage,
    Field
  },
  computed: {
    getUlOrigin() {
      return window.location.origin
    }
  },
  data() {
    return {
      itemCounts: [],
      cart: [],
      total: ''
    }
  },
  methods: {
    onSubmit(values) {
      this.$http
        .post(`/api/cart/checkout-order`, { ...values, cart: this.$cookies.get('cart') })
        .then((res) => {
          this.$cookies.remove('cart')
          console.log(res)
        })
    },
    isRequired(value) {
      if (!value) {
        return 'This field is required'
      }
      return true
    },
    validateEmail(value) {
      if (!value) {
        return 'This field is required'
      }
      const regex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i
      if (!regex.test(value)) {
        return 'This field must be a valid email'
      }
      // All is good
      return true
    },
    handleIncrement(productId) {
      this.itemCounts[productId] += 1
      this.updateCart(productId)
    },
    handleDecrement(productId) {
      if (this.itemCounts[productId] > 1) {
        this.itemCounts[productId] -= 1
        this.updateCart(productId)
      }
    },
    updateCart(productId) {
      this.$http
        .post(`/api/cart/update/${productId}`, {
          cart: this.$cookies.get('cart'),
          quantity: this.itemCounts[productId]
        })
        .then((res) => {
          this.$cookies.set('cart', res.data.data)
          this.getCart()
        })
    },
    removeItem(product) {
      this.$http
        .post(`/api/cart/remove/${product}`, { cart: this.$cookies.get('cart') })
        .then((res) => {
          this.$cookies.set('cart', res.data.data)
          this.getCart()
        })
    },
    getCart() {
      this.$http.get(`/api/cart?cart=${this.$cookies.get('cart')}`).then((res) => {
        this.cart = res.data.data.cart
        this.total = res.data.data.total
        res.data.data.cart.forEach((item) => {
          this.itemCounts[item.id] = item.quantity
        })
      })
    }
  },
  created() {
    this.getCart()
  }
}
</script>
<style scoped>
.productTableInfo {
  display: flex;
  align-items: center;
  width: 70px;
}
.productTableInfo h4 {
  font-size: 14px;
  color: #9c9c9c;
  font-weight: 400;
  margin-bottom: 0;
  margin-left: 40px;
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

h2 {
  font-size: 30px;
  color: #000000;
  font-weight: 600;
  margin-top: 100px;
  margin-bottom: 24px;
}
table thead tr th {
  font-size: 14px;
  color: #000000;
  font-weight: 400;
}
.totalAmount {
  display: flex;
  justify-content: space-between;
  margin: 1rem 0;
  width: 80%;
  margin: auto;
}
.CheckoutBtns {
  display: flex;
  justify-content: space-between;
  margin-top: 90px;
}
.CheckoutBtns .contShoppingBtn {
  font-size: 20px;
  color: #d4d4d4;
  font-weight: 800;
  text-decoration: none;
}
.CheckoutBtns .CheckoutBtn {
  width: 156px;
  height: 40px;
  background-color: #000000;
  border-radius: 6px;
  color: #ffffff;
  font-size: 20px;
  font-weight: 400;
  text-decoration: none;
  display: flex;
  justify-content: center;
  align-items: center;
}
.totalAmount h4 {
  font-size: 16px;
  color: #000000;
  font-weight: 600;
}
.totalAmount h2 {
  font-size: 20px;
  color: #000000;
  font-weight: 600;
  margin: 0;
}
</style>
