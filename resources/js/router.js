import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import HomePage from './pages/HomePage.vue';
import AboutPage from './pages/AboutPage.vue';
import BlogPage from './pages/BlogPage.vue';
import SinglePost from './pages/SinglePost.vue';
import ContactPage from './pages/ContactPage.vue';
import Page404 from './pages/Page404.vue';

// Regole per il routing
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomePage
        },
        {
            path: '/about',
            name: 'about',
            component: AboutPage
        },
        {
            path: '/blog',
            name: 'blog',
            component: BlogPage
        },
        {
            path: '/blog/:slug',
            name: 'single-post',
            component: SinglePost
        },
        {
            path: '/contact',
            name: 'contact',
            component: ContactPage
        },
        {
            path: '/*',
            name: 'Page404',
            component: Page404
        }
    ]
  });

  export default router;