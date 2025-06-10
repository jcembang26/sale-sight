<!-- src/views/Register.vue -->
<template>
    <div class="register-page">
      <h1>Register</h1>
      <form @submit.prevent="register">
        <div>
          <label>Email:</label>
          <input type="email" v-model="email" required />
        </div>
        <div>
          <label>Name:</label>
          <input type="text" v-model="name" required />
        </div>
        <div>
          <label>Password:</label>
          <input type="password" v-model="password" required />
        </div>
        <div>
          <label>Confirm Password:</label>
          <input type="password" v-model="password_confirmation" required />
        </div>
        <button type="submit">Register</button>
      </form>
  
      <p>
        Already have an account?
        <router-link to="/login">Login here</router-link>
      </p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  
  const name = ref('');
  const email = ref('');
  const password = ref('');
  const password_confirmation = ref('');
  
  const router = useRouter();
  
  const register = async () => {
    try {
      await axios.post('/api/register', {
        name: name.value,
        email: email.value,
        password: password.value,
        password_confirmation: password_confirmation.value,
      });
      // Optionally auto-login or redirect to login page
      router.push('/login');
    } catch (error) {
      console.error(error);
      alert('Registration failed.');
    }
  };
  </script>
  <style scoped>
  .register-page {
    max-width: 400px;
    margin: 80px auto; /* center */
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
    color: #333;
  }
  
  .register-page h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #444;
  }
  
  .register-page form {
    display: flex;
    flex-direction: column;
  }
  
  .register-page form > div {
    margin-bottom: 15px;
  }
  
  .register-page label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }
  
  .register-page input[type="email"],
  .register-page input[type="text"],
  .register-page input[type="password"],
  .register-page button {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
  }
  
  .register-page button {
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s ease;
  }
  
  .register-page button:hover {
    background-color: #45a049;
  }
  
  .register-page p {
    text-align: center;
    margin-top: 15px;
  }
  
  .register-page a {
    color: #007BFF;
    text-decoration: none;
  }
  
  .register-page a:hover {
    text-decoration: underline;
  }
  </style>
  