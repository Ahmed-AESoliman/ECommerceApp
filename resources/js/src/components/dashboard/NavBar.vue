<template>
<nav class="nav nav-borders">
    <router-link class="nav-link  ms-0" :class="{ 'active': isActive === 'products' }" to="/products">Products</router-link>
    <router-link class="nav-link  ms-0" :class="{ 'active': isActive === 'addProduct' }" to="/add-product">add Product</router-link>
    <router-link class="nav-link" :class="{ 'active': isActive === 'orders' }" to="/orders">Orders</router-link>
    <router-link class="nav-link" :class="{ 'active': isActive === 'categories' }" to="/categories">Categories</router-link>
</nav>
<hr class="mt-0 mb-4">
</template>

<script>
export default {
    computed: {
        isActive() {
            return this.$route.name;
        }
    }
};
</script>

<style>
/* Add your component's styles here */
</style>
