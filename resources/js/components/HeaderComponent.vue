<template>
    <header>
        <nav class="container">
            <router-link :to="{name: menuLink.routeName}" 
            v-for="(menuLink, index) in menuLinks" :key="index">
                {{menuLink.linkText}}
            </router-link>
            <a href="/admin">Admin privata</a>
        </nav>
    </header>
</template>

<script>
export default {
    name: 'HeaderComponent',
    data() {
        return {
            menuLinks: [
                {
                    routeName: 'home',
                    linkText: 'Home'
                },
                {
                    routeName: 'about',
                    linkText: 'About'
                },
                {
                    routeName: 'blog',
                    linkText: 'Blog'
                }
            ]
        }
    }
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