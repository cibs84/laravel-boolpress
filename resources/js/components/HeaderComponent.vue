<template>
    <header>
        <nav class="container">
            <router-link to="/">Home</router-link>
            <router-link to="/about">About</router-link>
            <router-link to="/blog">Blog</router-link>
            <a href="/admin">Admin privata</a>
        </nav>
    </header>
</template>

<script>
export default {
    name: 'HeaderComponent'
}
</script>

<style lang="scss" scoped>
nav {
    
    a {
        font-size: 1.5rem;
        padding: 1rem;
        display: inline-block;
    }
    &:first-child {
        padding-left: 0;
    }
}
</style>