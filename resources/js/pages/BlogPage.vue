<template>
    <div class="container">
        <PostsComponent />
    </div>
</template>

<script>
import PostsComponent from "../components/PostsComponent.vue";

export default {
    name: 'BlogPage',
    components: {
        PostsComponent
    }
}
</script>