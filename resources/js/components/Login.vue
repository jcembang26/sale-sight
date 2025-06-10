<!-- src/views/Login.vue -->
<template>
    <div class="login-page">
      <h1>Login</h1>
      <form @submit.prevent="login">
        <div>
          <label>Email:</label>
          <input type="email" v-model="email" required />
        </div>
        <div>
          <label>Password:</label>
          <input type="password" v-model="password" required />
        </div>
        <button type="submit">Login</button>
      </form>
  
      <p>
        Don't have an account?
        <router-link to="/register">Register here</router-link>
      </p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  
  const email = ref('');
  const password = ref('');
  
  const router = useRouter();
  
  const login = async () => {
    try {
      const response = await axios.post('/api/login', {
        email: email.value,
        password: password.value,
      });
      const token = response.data.token;
      // Store token (localStorage or Vuex/pinia)
      localStorage.setItem('token', token);
      router.push('/dashboard');
    } catch (error) {
      console.error(error);
      alert('Login failed.');
    }
  };
  </script>
  <style scoped>
  .login-page {
    max-width: 400px;
    margin: 80px auto; /* center */
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
    color: #333;
  }
  
  .login-page h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #444;
  }
  
  .login-page form {
    display: flex;
    flex-direction: column;
  }
  
  .login-page form > div {
    margin-bottom: 15px;
  }
  
  .login-page label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }
  
  .login-page input[type="email"],
  .login-page input[type="password"],
  .login-page button {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
  }
  
  .login-page button {
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s ease;
  }
  
  .login-page button:hover {
    background-color: #45a049;
  }
  
  .login-page p {
    text-align: center;
    margin-top: 15px;
  }
  
  .login-page a {
    color: #007BFF;
    text-decoration: none;
  }
  
  .login-page a:hover {
    text-decoration: underline;
  }
  </style>
  