<template>
<div class="container">
    <NavBar />
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-4">
                    <label class="form-label">Product Name</label>
                    <input type="text" class="form-control" v-model="name">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Category</label>
                    <select class="form-select" v-model="category">
                        <option selected value="">select</option>
                        <option  v-for="(category,index) in categoryArr" :key="index" :value="category.id">{{category.name}}</option>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Sub-Category</label>
                      <select class="form-select" v-model="subCategory">
                        <option selected value="">select</option>
                        <option  v-for="(category,index) in subCategoryArr" :key="index" :value="category.id">{{category.name}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-12 mt-5">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th scope="col">Name</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">In Stock</th>
                        <th scope="col">On Order</th>
                        <th scope="col">Category</th>
                        <th scope="col">Sub Category</th>
                    </thead>
                    <tbody>
                        <tr v-for="(product ,index) in prodcts" :key="index">
                            <td>{{ product.name }}</td>
                            <td>{{ product.unit_price }}</td>
                            <td>{{ product.unit_in_stock }}</td>
                            <td>{{ product.unit_on_order }}</td>
                            <td>{{ product.category }}</td>
                            <td>{{ product.sub_category }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 text-end">

        </div>
    </div>
</div>
</template>

<script>
import NavBar from '../../components/dashboard/NavBar.vue';
export default {
    components: {
        NavBar
    },
    beforeCreate() {
        if (this.$cookies.get('token') == '') this.$router.push('/login')
    },
    data() {
        return {
            prodcts: [],
            categoryArr: [],
            subCategoryArr: [],
            name: null,
            category: null,
            subCategory: null,
        }
    },
    methods: {
        fetchProducts(ctx, callback) {
            this.$http
                .get(`/api/product`, {
                    params: {
                        name: this.name,
                        category: this.category,
                        sub_category: this.subCategory,
                    },
                    headers: {
                        Authorization: `Bearer ${this.$cookies.get('token')}`
                    }
                })
                .then((res) => {
                    this.products = res.data.data
                })
                .catch((error) => {
                    console.error('Error fetching products:', error)
                })
        },
        fetchCategories() {
            this.$http
                .get(`/api/category`, {
                    headers: {
                        Authorization: `Bearer ${this.$cookies.get('token')}`
                    }
                })
                .then((res) => {
                    this.categoryArr = res.data.data
                })
                .catch((error) => {
                    console.error('Error fetching products:', error)
                })
        },
        fetchSubCategories() {
            this.$http
                .get(`/api/category`, {
                    params: {
                        category: this.category,
                    },
                    headers: {
                        Authorization: `Bearer ${this.$cookies.get('token')}`
                    }
                })
                .then((res) => {
                    this.subCategoryArr = res.data.data
                })
                .catch((error) => {
                    console.error('Error fetching products:', error)
                })
        },
    },
    created() {
        this.fetchProducts()
        this.fetchCategories()
    },
    watch: {
        name() {
            this.fetchProducts()
        },
        category() {
            this.fetchProducts()
            this.fetchSubCategories()
        },
        subCategory() {
            this.fetchProducts()
        }
    },

}
</script>

<style>

</style>
