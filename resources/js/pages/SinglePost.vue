<template>
    <div class="container">
        <!-- Title and Tags -->
        <!-- SE la chiamata api non è stata ancora eseguita ALLORA visualizza solo lo spinner di caricamento -->
        <div v-if="post">
            <!-- SE i tag sono presenti, li visualizzA insieme al titolo -->
            <div v-if="post.tags.length > 0">
                <h1 class="mt-4">
                    {{post.title}}
                    <span v-for="(tag, index) in post.tags" 
                          :key="index" 
                          class="badge bg-warning text-dark mr-2"
                    >
                        {{tag.name}}
                    </span>
                </h1>
            </div>
            <!-- ALTRIMENTI visualizza solo il titolo -->
            <div v-else>
                <h1>{{post.title}}</h1>
            </div>

            <!-- Meta Data -->
            <div class="meta-data my-4">
                <h5><strong>Creato il: </strong>{{post.created_at}}</h5>
                <h5><strong>Aggiornato il: </strong>{{post.updated_at}}</h5>
                <h5 v-if="post.category"><strong>Categoria: </strong>{{post.category.name}}</h5>
                <h5 v-else><strong>Categoria: </strong>Nessuna</h5>
            </div>

            <!-- Image -->
            <img v-if="post.cover" :src="post.cover" class="card-img-top mb-4" :alt="post.title">

            <!-- Content -->
            <p class="post-content">{{ post.content }}</p>
        </div>
        <div v-else>
            <div class="d-flex justify-content-center align-items-center" style="height:calc(100vh - 7.5rem);">
                <div class="spinner-border" role="status"></div>
            </div>
        </div>

        

    </div>
</template>

<script>
export default {
    name: 'SinglePost',
    data() {
        return {
            post: null
        }
    },
    methods: {
        getSinglePost() {
            axios
                .get('/api/posts/' + this.$route.params.slug)
                .then(response => {
                    // Se abbiamo trovato un post ok popoliamo this.post e lo stampiamo
                    if(response.data.success) {
                        this.post = response.data.results;
                    } else {
                        // Altrimeneti se il post non è stato trovato, reindirizziamo l'utente a 404
                        this.$router.push({name:'Page404'});
                    }
                })
        }
    },
    mounted() {
        // Impostato un ritardo nella chiamata per testare il v-if-else 
        // con la visualizzazione dello spinner di caricamento
        setTimeout(this.getSinglePost, 500);
    }
}
</script>

<style lang="scss" scoped>
.badge {
    font-size: 40%;
    vertical-align: text-top;
}
</style>