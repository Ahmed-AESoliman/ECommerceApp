<template>
<div class="container">
    <NavBar />
    <AddCategory @refresh-tbl="refreshTbl" />
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-4">
                    <label class="form-label">Category Name</label>
                    <input type="text" class="form-control" v-model="name">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Category</label>
                    <select class="form-select" v-model="category">
                        <option selected value="">select</option>
                        <option v-for="(category,index) in categoryArr" :key="index" :value="category.id">{{category.category_name}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-12 text-end mt-5 mb-2">
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add New</button>
        </div>
        <div class="col-12 mt-2">
            <div class="table-responsive">
                <table class="table ">
                    <thead class="border-bottom">
                        <th scope="col">Category</th>
                        <th scope="col">Sub Category</th>
                        <th scope="col">action</th>
                    </thead>
                    <tbody>
                        <tr v-for="(categor ,index) in categories" :key="index">
                            <td>{{ categor.main_category }}</td>
                            <td>{{ categor.name }}</td>
                            <td class="text-primry">
                                <a data-bs-toggle="offcanvas" class="dropdown-item" :href="'#offcanvasUpdate_' + categor.parent_category" role="button" :aria-controls="'offcanvasUpdateLabel_' + selectedCategory">
                                    edit
                                </a>
                            </td>
                            <UpdateCategory @refresh-tbl="refreshTbl" :selectedCategory="categor.parent_category" />
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 text-end">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" @click="() => { page > 1 ? page-- : null }" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" @click="()=>{page === maxPage ? null :page++ }" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
</template>

<script>
import NavBar from '../../components/dashboard/NavBar.vue';
import AddCategory from '../../components/dashboard/AddCategory.vue';
import UpdateCategory from '../../components/dashboard/UpdateCategory.vue';
export default {
    components: {
        NavBar,
        AddCategory,
        UpdateCategory
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
            page: 1,
            maxPage: 1,
            refresh: 0,
        }
    },
    methods: {
        fetchCategories() {
            this.$http
                .get(`/api/category`, {
                    params: {
                        name: this.name,
                        category: this.category,
                        page: this.page
                    },
                    headers: {
                        Authorization: `Bearer ${this.$cookies.get('token')}`
                    }
                })
                .then((res) => {
                    this.categories = res.data.data
                    this.maxPage = res.data.meta.last_page
                })
                .catch((error) => {
                    console.error('Error fetching products:', error)
                })
        },
        fetchMainCategories() {
            this.$http
                .get(`/api/category-list`, {
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
        refreshTbl() {
            this.fetchCategories()
        },
    },
    created() {
        this.fetchCategories()
        this.fetchMainCategories()
    },
    watch: {
        name() {
            this.fetchCategories()
        },
        category() {
            this.fetchCategories()
        },
        page(newVal) {

            this.fetchCategories()

        }
    },

}
</script>

<style>

</style>
