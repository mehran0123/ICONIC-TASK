<template>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <form class="card p-4" @submit.prevent="login" style="max-width: 400px; width: 100%;">
            <h1 class="text-center mb-4">Login</h1>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" v-model="email" required />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" v-model="password" required />
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</template>

<script setup>
import axios from "axios"
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const email = ref('');
const password = ref('');
const router = useRouter();

const login = async () => {
    try {
        const response = await axios.post('http://127.0.0.1:8000/api/auth/login', {
            email: email.value,
            password: password.value,
        });

         console.log('response =>>',response);

        if (response.data._metadata.outcomeCode === 200) {

             localStorage.setItem('token', `${response.data.records.token}`);
            // Redirect to dashboard upon successful login
            router.push('/dashboard');
        } else {
            // Handle login error
            alert(`Login failed: ${response.data._metadata.message}`)
            console.error('Login failed:', response.data._metadata.message);
        }
    } catch (error) {
        console.error('Error:', error.message);
    }
};
</script>

<style scoped>
.container {
    height: 100vh;
    background-color: #f5f5f5;
}

@media (max-width: 768px) {
    .container {
        padding: 0 1rem;
    }
    .card {
        max-width: 100%;
    }
}
</style>
