<template>
    <div class="container mt-5">
      <div class="card shadow p-4">
        <h2 class="text-center mb-4">{{ isLogin ? 'Iniciar Sesión' : 'Registrar Usuario' }}</h2>

        <form @submit.prevent="isLogin ? login() : register()">

<!-- Mostrar campo de nombre solo en registro -->
          <div v-if="!isLogin" class="form-group mb-3">
            <label>Nombre</label>
            <input type="text" class="form-control" v-model="form.name" required />
          </div>

            <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" class="form-control" v-model="form.email" required />
          </div>

          <div class="form-group mb-3">
            <label>Contraseña</label>
            <input type="password" class="form-control" v-model="form.password" required />
          </div>

          <button class="btn btn-primary w-100" type="submit">
            {{ isLogin ? 'Ingresar' : 'Registrar' }}
          </button>
        </form>

        <div class="text-center mt-3">
          <a href="#" @click.prevent="isLogin = !isLogin" class="text-primary" style="text-decoration: underline;">
            {{ isLogin ? '¿No tienes cuenta? Regístrate aquí' : '¿Ya tienes cuenta? Inicia sesión' }}
          </a>
        </div>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        isLogin: true,
        form: {
          name: '',
          email: '',
          password: ''
        }
      };
    },
    methods: {
      async login() {
        try {
          await axios.post('/api/login', {
            email: this.form.email,
            password: this.form.password
          }, { withCredentials: true });

          alert('Sesión iniciada');
          this.$router.push('/dashboard');
        } catch {
          alert('Credenciales incorrectas');
        }
      },
      async register() {
        try {
          await axios.post('http://localhost:8000/api/register', this.form, { withCredentials: true });
          alert('Usuario registrado');
          this.isLogin = true;
        } catch {
          alert('Error al registrar');
        }
      }
    }
  };
  </script>
