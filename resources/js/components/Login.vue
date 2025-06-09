<template>
    <div>
      <h2>Login</h2>
      <form @submit.prevent="submitLogin">
        <div>
          <label>Email:</label>
          <input v-model="email" type="email" required />
        </div>
        <div>
          <label>Password:</label>
          <input v-model="password" type="password" required />
        </div>
        <button type="submit">Login</button>
        <p v-if="error" style="color:red">{{ error }}</p>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  import { ref } from 'vue';
  
  export default {
    setup() {
      const router = useRouter();
      const email = ref('');
      const password = ref('');
      const error = ref(null);
  
      const submitLogin = async () => {
        error.value = null;
        try {
          await axios.post('/api/login', {
            email: email.value,
            password: password.value,
          }, { withCredentials: true });
  
          // After login, redirect to dashboard
          router.push('/dashboard');
        } catch (err) {
          error.value = err.response?.data?.message || 'Login failed';
        }
      };
  
      return { email, password, error, submitLogin };
    },
  };
  </script>
  