<template>
    <div class="container">
        <h1>SinglePost</h1>
    </div>
</template>

<script>
export default {
    name: 'SinglePost',
    methods: {
        getSinglePost() {
            axios
                .get('/api/posts/', {
                    data: {
                        slug: this.$route.params.slug
                    }
                })
                .then(response => {
                    
                })
        }
    },
    mounted() {
        this.getSinglePost();
    }
}
</script>