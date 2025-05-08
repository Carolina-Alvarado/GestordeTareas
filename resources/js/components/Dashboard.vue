<template>
    <div class="d-flex" style="height: 100vh;">
      <!-- Sidebar fijo -->
      <div class="sidebar bg-dark text-black p-3">
        <h4 class="mb-4 font-weight-bold text-black">BIENVENIDO</h4>
        <ul class="list-unstyled">
          <li><router-link to="/task" class="text-black d-block py-2">📊 Panel de Control</router-link></li>
          <li><router-link to="/tasklist" class="text-black d-block py-2">📝 Tareas</router-link></li>
          <li><a href="#" class="text-danger d-block py-2" @click.prevent="logout">🚪 Cerrar sesión</a></li>
        </ul>
      </div>

      <!-- Contenido principal -->
      <div class="flex-grow-1">
        <b-navbar toggleable="lg" class = "navbar-custom" >
          <b-navbar-brand>SISTEMA DE GESTION DE TAREAS </b-navbar-brand>
          <b-navbar-nav class="ml-auto">
            <b-nav-item disabled>
              {{ user.name || 'Usuario' }}
            </b-nav-item>
          </b-navbar-nav>
        </b-navbar>

        <div class="p-4">
          <router-view></router-view>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    name: 'Dashboard',
    data() {
      return {
        user: {},
      };
    },
    created() {
      this.fetchUser();
    },
    methods: {
      fetchUser() {
        this.axios.get('/api/user')
          .then(res => {
            this.user = res.data;
          })
          .catch(() => {
            this.$router.push('/login');
          });
      },
      logout() {
        this.axios.post('/api/logout', {}, { withCredentials: true }).then(() => {
          localStorage.removeItem('token');
          this.$router.push('/login');
        }).catch(err => {
          console.error('Error al cerrar sesión:', err.response?.data || err);
        });
      }

    }
  };
  </script>

  <style scoped>
  .sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    overflow-y: auto;
    background-color: #BCBCBCFF !important;
  }
  .flex-grow-1 {
    margin-left: 250px;
  }

  .navbar-custom {
  background-color: #ffe5b4 !important;
  color: #000000;
}

  </style>
