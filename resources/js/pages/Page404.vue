<template>
    <div class="container">
        <h1>Contenuto non trovato</h1>
        <h5>
            Visita il nostro 
            <router-link :to="{name:'blog'}">Blog</router-link>
        </h5>
    </div>
</template>

<script>
export default {
    name: 'Page404'
}
</script>