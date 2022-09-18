<template>
    <header>
        <nav class="container">
            <router-link  v-for="(menuLink, index) in menuLinks"
                          :to="{name: menuLink.routeName}"
                          :key="index"
            >
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
                },
                {
                    routeName: 'contact',
                    linkText: 'Contatti'
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