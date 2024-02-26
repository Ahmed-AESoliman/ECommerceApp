<template>
<div class="container">
    <NavBar />
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-4">
                    <label class="form-label">Category</label>
                    <input type="text" class="form-control" v-model="name">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Sub Category</label>
                    <input type="text" class="form-control" v-model="name">
                </div>
            </div>
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
                        name: this.name,
                        category: this.category,
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
