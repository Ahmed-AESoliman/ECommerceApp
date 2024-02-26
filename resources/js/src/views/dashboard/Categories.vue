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
            </div>
        </div>
        <div class="col-12 mt-5">
            <div class="table-responsive">
                <table class="table">
                    <thead>
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
            categories: [],
            categoryArr: [],
            name: null,
            category: null,

        }
    },
    methods: {
        fetchCategories() {
            this.$http
                .get(`/api/category`, {
                    params: {
                        name:this.name,
                        category:this.category,
                    },
                    headers: {
                        Authorization: `bearer ${this.$cookies.get('token')}`
                    }
                })
                .then((res) => {
                    this.categoryArr = res.data.data
                })
                .catch((error) => {
                    console.error('Error fetching products:', error)
                })
        },

    },
    created() {
        this.fetchCategories()
    },
    watch: {
        name() {
            this.fetchCategories()
        },
        category() {
            this.fetchCategories()
        },
    },

}
</script>

<style>

</style>
