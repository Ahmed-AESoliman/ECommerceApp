<template>
<div>
    <div class="container">
        <NavBar />
        <div class="row">
            <div class="col-12">
                <!-- <DropFile /> -->
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">product name</label>
                    <Field name="name" type="text"  class="form-control" placeholder="01112005445" />
                    <ErrorMessage name="name" v-slot="{message}">
                        <p class="text-danger">{{ message }}</p>
                    </ErrorMessage>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">category</label>
                    <Field name="category" as="select"  class="form-control" v-model="selectedCategory">
                        <option selected value="">select</option>
                        <option v-for="(category,index) in categories" :key="index" :value="category.id">{{category.category_name}}</option>
                    </Field>
                    <ErrorMessage name="category" v-slot="{message}">
                        <p class="text-danger">{{ message }}</p>
                    </ErrorMessage>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">sub-category</label>
                    <Field name="sub_category" as="select"  class="form-control" >
                        <option selected value="">select</option>
                        <option v-for="(category,index) in subCategories" :key="index" :value="category.id">{{category.category_name}}</option>
                    </Field>
                    <ErrorMessage name="sub_category" v-slot="{message}">
                        <p class="text-danger">{{ message }}</p>
                    </ErrorMessage>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-3">
                    <label class="form-label">unit            price</label>
                    <Field name="unit_price" as="text"  class="form-control"/>
                    <ErrorMessage name="unit_price" v-slot="{message}">
                        <p class="text-danger">{{ message }}</p>
                    </ErrorMessage>
                </div>
            </div>
        </div>

    </div>
</div>
</template>

<script>
import DropFile from '../../components/dropFile/DropFile.vue';
import NavBar from '../../components/dashboard/NavBar.vue';
import { Field, Form, ErrorMessage } from 'vee-validate';
import * as yup from 'yup';
export default {
    components: {
        DropFile,
        NavBar,
        Field,
        Form,
        ErrorMessage
    },
    data() {
        return {
            categories: [],
            subCategories: [],
            selectedCategory:"",
            validationSchema: {
            name: yup.string().required(),
            category: yup.string().required(),
            sub_category: yup.string(),
        }
        }
    },
    methods: {
        fetchCategories() {
            this.$http.get(`/api/category-list`).then((res) => {
                this.categories = res.data.data
            })
        },
        fetchSubCategories() {
            this.$http.get(`/api/sub-category-list?main_category=${this.selectedCategory}`).then((res) => { this.subCategories = res.data.data })
        }
    },
    created() {
        this.fetchCategories()
    },
    watch: {
        selectedCategory() {
            this.fetchSubCategories()
        }
    }
}
</script>

<style>
</style>
