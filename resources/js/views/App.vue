<template>
    <div>
        <HeaderComponent />

        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
import PostsComponent from '../components/PostsComponent.vue';
import HeaderComponent from '../components/HeaderComponent.vue';
import HomePage from '../pages/HomePage.vue';
import AboutPage from '../pages/AboutPage.vue';
import BlogPage from '../pages/HomePage.vue';

export default {
    name: 'App',
    components: {
        HeaderComponent,
        PostsComponent,
        HomePage,
        AboutPage,
        BlogPage
    },
    data() {
        return {
            
        }
    },
    methods: {
        
    },
    mounted() {
       
    }
}
</script>