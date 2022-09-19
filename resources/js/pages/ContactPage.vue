<template>
    <div class="container">
        <h1>Contatti</h1>
        <!-- Messages for created/updated post -->
            <div v-if="success" class="alert alert-success" role="alert">
                Grazie per averci contattato!
            </div>
        <!-- Form -->
        <form @submit.prevent="sendMessage">
            <div class="mb-3">
                <label for="user-name" class="form-label">Nome</label>
                <input v-model="userName" type="text" class="form-control" id="user-name">
                <!-- Errors message -->
                <div v-if="errors.name">
                    <div v-for="error, index in errors.name" :key="index" class="alert alert-danger" role="alert">
                        {{ error }}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="user-email" class="form-label">Email</label>
                <input v-model="userEmail" type="email" class="form-control" id="user-email">
                <!-- Errors message -->
                <div v-if="errors.email">
                    <div v-for="error, index in errors.email" :key="index" class="alert alert-danger" role="alert">
                        {{ error }}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="user-message" class="form-label">Messaggio</label>
                <textarea v-model="userMessage" class="form-control" id="user-message" rows="5"></textarea>
                <!-- Errors message -->
                <div v-if="errors.message">
                    <div v-for="error, index in errors.message" :key="index" class="alert alert-danger" role="alert">
                        {{ error }}
                    </div>
                </div>
            </div>
            <!-- Submit -->
            <input type="submit" value="Invia" class="btn btn-primary" :disabled="sending">
        </form>
    </div>
</template>

<script>
export default {
    name: 'ContactPage',
    data() {
        return {
            userName: '',
            userEmail: '',
            userMessage: '',
            success: false,
            errors: {},
            sending: false
        }
    },
    methods: {
        sendMessage() {
            this.sending = true;
            this.success = false;

            axios.post('/api/leads', {
                    name: this.userName,
                    email: this.userEmail,
                    message: this.userMessage
                })
                .then((response) => {
                    if (response.data.success) {
                        this.success = true;

                        this.userName = '';
                        this.userEmail = '';
                        this.userMessage = '';
                        this.errors = {};
                    } else {
                        this.errors = response.data.errors;
                    }

                    this.sending = false;
                });
        }
    }
}
</script>