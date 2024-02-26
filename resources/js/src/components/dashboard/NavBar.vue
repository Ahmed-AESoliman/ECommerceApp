<template>
<nav class="nav nav-borders">
    <a class="nav-link  ms-0" :class="{ 'active': isActive === 'products' }" href="/products">Products</a>
    <a class="nav-link" :class="{ 'active': isActive === 'orders' }" href="/orders">Orders</a>
    <a class="nav-link" :class="{ 'active': isActive === 'categories' }" href="/categories">Categories</a>
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
