<template>
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasUpdate" aria-labelledby="offcanvasUpdateLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasUpdateLabel">update Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="row">
            <div class="col-12">
                <label class="form-label">Category</label>
                <input type="text" class="form-control" v-model="name">
                <p class="text-danger">{{nameError}}</p>
            </div>
            <div class="col-12 mt-3">
                <label class="form-label">Sub Category</label>
                <div class='tag-input'>
                    <div v-for='(tag, index) in categories' :key='tag' class='tag-input__tag'>
                        {{ tag }}
                        <span @click='removeTag(index)'>x</span>
                    </div>
                    <input type='text' placeholder="Enter a categor" class='tag-input__text' @keydown.enter='addTag' @keydown.188='addTag' @keydown.delete='removeLastTag' />
                </div>
                <p class="text-danger">{{categoriesError}}</p>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-between align-items-center">
            <button type="button" @click="onSubmit" class="btn btn-dark w-100">Submit</button>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "AddCategory",
    props:["selectedCategory"],
    data() {
        return {
            categories: [],
            categoriesError: '',
            name: null,
            nameError: '',
        }
    },
    methods: {
        onSubmit() {
            if (!this.name) {
                this.nameError = 'This field is required'
                return
            }
            if (this.categories.length == 0) {
                this.categoriesError = 'This field is required'
                return
            }
            this.$http
                .post(`/api/category/create`, {
                    category_name: this.name,
                    sub_category: this.categories,
                }, {
                    headers: {
                        Authorization: `Bearer ${this.$cookies.get('token')}`
                    }
                })
                .then((res) => {
                    this.$emit('refresh-tbl')
                    document.querySelector('.btn-close').click()
                })
                .catch((error) => {
                    console.error('Error store category:', error)
                })
        },
        addTag(event) {
            event.preventDefault();
            let val = event.target.value.trim();
            if (val.length > 0) {
                if (this.categories.length >= 1) {
                    for (let i = 0; i < this.categories.length; i++) {
                        if (this.categories[i] === val) {
                            return false;
                        }
                    }
                }
                this.categories.push(val);
                event.target.value = "";
                console.log(this.categories);
            }
        },
        removeTag(index) {
            this.categories.splice(index, 1);
        },
        removeLastTag(event) {
            if (event.target.value.length === 0) {
                this.removeTag(this.categories.length - 1);
            }
        },
        fetchCategory() {
            this.$http.get(``)
        }
    },
    created() {

    },
    watch: {

    },

}
</script>

<style scoped>
a {
    position: absolute;
    right: 15px;
    bottom: 15px;
    font-weight: bold;
    text-decoration: none;
    color: #00003a;
    font-size: 20px;
}

/*tag input style*/

.tag-input {
    border: 1px solid #d9dfe7;
    background: #fff;
    border-radius: 4px;
    font-size: 0.9em;
    min-height: 45px;
    box-sizing: border-box;
    padding: 0 10px;
    font-family: "Roboto";
    margin-bottom: 10px;
}

.tag-input__tag {
    height: 24px;
    color: white;
    float: left;
    font-size: 14px;
    margin-right: 10px;
    background-color: #667eea;
    border-radius: 15px;
    margin-top: 10px;
    line-height: 24px;
    padding: 0 8px;
    font-family: "Roboto";
}

.tag-input__tag>span {
    cursor: pointer;
    opacity: 0.75;
    display: inline-block;
    margin-left: 8px;
}

.tag-input__text {
    border: none;
    outline: none;
    font-size: 1em;
    line-height: 40px;
    background: none;
}
</style>
