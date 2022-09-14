<template>
    <div class="container">
        <h1>{{pageTitle}}</h1>
        <div class="row row-cols-3">
            <!-- LOOP - Post col -->
            <div class="col mt-4" v-for="thisPost in posts" :key="thisPost.id">
                <PostDetails :post="thisPost"/>
            </div>
        </div>

        <!-- Pagination -->
        <nav class="mt-4" aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <!-- Previous Button -->
                <li class="page-item" :class="{'disabled': currentPage == 1}">
                    <a class="page-link" href="#" @click.prevent="getPosts(currentPage - 1)" tabindex="-1" aria-disabled="true">Previous</a>
                </li>

                <li v-for="(pageNumber, index) in lastPage" :key="index" class="page-item" :class="{'active': pageNumber === currentPage}">
                    <a class="page-link" href="#" @click.prevent="getPosts(pageNumber)">{{pageNumber}}</a>
                </li>

                <!-- Next Button -->
                <li class="page-item" :class="{'disabled': currentPage == lastPage}">
                    <a class="page-link" href="#" @click.prevent="getPosts(currentPage + 1)">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import PostDetails from './PostDetails.vue';

export default {
    name: 'PostsComponent',
    components: {
        PostDetails
    },
    data() {
        return {
            pageTitle: 'Tutti i post',
            posts: [],
            currentPage: null,
            lastPage: null
        }
    },
    methods: {
        getPosts(pageNumber) {
            axios.get('/api/posts', {
                params: {
                    page: pageNumber
                }
            })
            .then((response) => {
                this.posts = response.data.results.data;
                this.currentPage = response.data.results.current_page;
                this.lastPage = response.data.results.last_page;
            })
        }
    },
    mounted() {
        this.getPosts(1);
    }
}
</script>