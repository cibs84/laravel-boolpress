<template>
    <div class="container">
        <div class="row row-cols-3">
            <!-- LOOP - Post col -->
            <div class="col mt-4" v-for="post in posts" :key="post.id">
                <div class="card">
                    <!-- <img src="..." class="card-img-top" alt="..."> -->
                    <div class="card-body">
                        <h5 class="card-title">{{post.title}}</h5>
                        <p class="card-text">{{truncateText(post.content)}}</p>
                        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PostsComponent',
    data() {
        return {
            posts: []
        }
    },
    methods: {
        truncateText(text) {
            if (text.length > 75) {
                return text.slice(0, 75) + '...';
            }
        },
        getPosts() {
            axios.get('/api/posts', {params: {
                page: 1
            }})
            .then((response) => {
                this.posts = response.data.results;
            })
        }
    },
    mounted() {
        this.getPosts();
    }
}
</script>