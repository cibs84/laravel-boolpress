<template>
    <div>
        <HeaderComponent />

        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
import HeaderComponent from '../components/HeaderComponent.vue';

export default {
    name: 'App',
    components: {
        HeaderComponent,
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