<template>
    <b-container class="login-container">
      <b-card class="my-5 mx-auto login-card" style="max-width: 400px;">
        <h3 class="text-center mb-4">Iniciar Sesión</h3>
        <b-form @submit.prevent="login">
          <b-form-group label="Email">
            <b-form-input v-model="email" type="email" required />
          </b-form-group>

          <b-form-group label="Contraseña">
            <b-form-input v-model="password" type="password" required />
          </b-form-group>

          <b-button type="submit" variant="primary" block>Ingresar</b-button>
          <p class="mt-3 text-center">
            ¿No tienes cuenta?
            <router-link to="/register" class="text-primary font-weight-bold">Regístrate</router-link>
          </p>
        </b-form>
      </b-card>
    </b-container>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        email: '',
        password: '',
      };
    },
    methods: {
      async login() {
        try {
          await axios.get('/sanctum/csrf-cookie');
          const res = await axios.post('/api/login', {
            email: this.email,
            password: this.password,
          });
          localStorage.setItem('token', res.data.token);
          this.$router.push('/task');
        } catch (err) {
          alert('Credenciales incorrectas');
        }
      }
    }
  };
  </script>

  <style scoped>

    .login-card {
      background-color: #fff;
      padding: 20px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      width: 100%;
      max-width: 400px;
    }

    .btn-primary {
      width: 100%;
      padding: 10px;
      background-color: #EED254FF;
      border: none;
      border-radius: 5px;
      color: white;
      font-size: 16px;
    }
  </style>
