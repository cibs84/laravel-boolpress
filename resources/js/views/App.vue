<template>
    <div>
        <div class="container">
            <a href="/admin">Admin privata</a>
        </div>

        <main>
            <PostsComponent />
        </main>
    </div>
</template>

<script>
import PostsComponent from '../components/PostsComponent.vue';

export default {
    name: 'App',
    components: {
        PostsComponent
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