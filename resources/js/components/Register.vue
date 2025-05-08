<template>
    <b-container class="register-container">
      <b-card class="my-5 mx-auto register-card" style="max-width: 400px;">
        <h3 class="text-center mb-4">Registro de Usuario</h3>
        <b-form @submit.prevent="register">
          <b-form-group label="Nombre">
            <b-form-input v-model="name" required />
          </b-form-group>

          <b-form-group label="Email">
            <b-form-input v-model="email" type="email" required />
          </b-form-group>

          <b-form-group label="Contraseña">
            <b-form-input v-model="password" type="password" required />
          </b-form-group>

          <b-button type="submit" variant="success" block>Registrarse</b-button>
          <p class="mt-3 text-center">
            ¿Ya tienes cuenta?
            <router-link to="/login" class="text-primary font-weight-bold">Inicia sesión</router-link>
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
        name: '',
        email: '',
        password: ''
      };
    },
    methods: {
      async register() {
        try {
          await axios.get('/sanctum/csrf-cookie');
          await axios.post('/api/register', {
            name: this.name,
            email: this.email,
            password: this.password,
          });
          this.$router.push('/login');
        } catch (error) {
          alert('Error al registrar usuario');
        }
      }
    }
  };
  </script>

  <style scoped>
    .register-card {
      background-color: #fff;
      padding: 20px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      width: 100%;
      max-width: 400px;
    }


    .btn-success {
      width: 100%;
      padding: 10px;
      background-color: #EED254FF;
      border: none;
      border-radius: 5px;
      color: white;
      font-size: 16px;
    }
  </style>

