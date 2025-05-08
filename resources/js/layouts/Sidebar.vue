<template>
    <b-sidebar visible shadow>
      <div class="p-3">
        <h5 class="text-white">Administrador</h5>
        <b-nav vertical class="text-white">
          <b-nav-item href="#">Panel de Control</b-nav-item>
          <b-nav-item href="#">Tareas</b-nav-item>
          <b-nav-item href="#">Evaluación</b-nav-item>
          <b-nav-item href="#">Departamentos</b-nav-item>
          <b-nav-item href="#">Cargos</b-nav-item>
          <b-nav-item href="#">Empleados</b-nav-item>
          <b-nav-item href="#">Evaluador</b-nav-item>
          <b-nav-item href="#">Usuarios</b-nav-item>
        </b-nav>
      </div>
    </b-sidebar>
  </template>

  <script>
  export default {
    name: 'Sidebar'
  }
  </script>

  <style scoped>
  .b-sidebar {
    background-color: #343a40;
    color: white;
  }
  </style>
