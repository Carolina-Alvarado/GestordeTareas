<template>
  <div>
    <h3 class="mb-4">📋 Mis Tareas</h3>

    <!-- Filtro por prioridad -->
    <div class="form-group">
      <label for="filtro">Filtrar por prioridad:</label>
      <select v-model="filtroPrioridad" class="form-control w-25">
        <option value="">Todas</option>
        <option value="baja">Baja</option>
        <option value="media">Media</option>
        <option value="alta">Alta</option>
      </select>
    </div>

    <!-- Tabla de tareas -->
    <table class="table table-bordered mt-3">
      <thead class="thead-light">
        <tr>
          <th>Descripción</th>
          <th>Prioridad</th>
          <th>Fecha Vencimiento</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="task in tareasFiltradas" :key="task.id">
          <td>{{ task.descripcion }}</td>
          <td>
            <span :class="{
              'badge badge-danger': task.prioridad === 'alta',
              'badge badge-warning': task.prioridad === 'media',
              'badge badge-success': task.prioridad === 'baja',
            }">
              {{ task.prioridad }}
            </span>
          </td>
          <td>{{ task.fecha_vencimiento }}</td>
          <td>
            <span :class="{
              'text-success': task.estado === 'completada',
              'text-secondary': task.estado === 'pendiente'
            }">
              {{ task.estado }}
            </span>
          </td>
          <td>
            <button class="btn btn-sm"
              :class="task.estado === 'pendiente' ? 'btn-success' : 'btn-secondary'"
              @click="toggleEstado(task)">
              {{ task.estado === 'pendiente' ? 'Marcar como Completada' : 'Marcar como Pendiente' }}
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'TaskList',
  data() {
    return {
      tareas: [],
      filtroPrioridad: '',
    };
  },
  computed: {
    tareasFiltradas() {
      if (!this.filtroPrioridad) return this.tareas;
      return this.tareas.filter(t => t.prioridad === this.filtroPrioridad);
    }
  },
  created() {
    this.obtenerTareas();
  },
  methods: {
    async obtenerTareas() {
      try {
        const token = localStorage.getItem('token');
        const res = await axios.get('/api/tasklist', {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        this.tareas = res.data;
      } catch (error) {
        console.error('Error al obtener tareas:', error);
        alert('Error al cargar las tareas. Verifica tu sesión.');
      }
    },
    async toggleEstado(tarea) {
      try {
        const token = localStorage.getItem('token');
        const nuevoEstado = tarea.estado === 'pendiente' ? 'completada' : 'pendiente';
        await axios.put(`/api/tasklist/${tarea.id}`, { estado: nuevoEstado }, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        tarea.estado = nuevoEstado;
      } catch (error) {
        console.error('Error al actualizar el estado:', error);
        alert('No se pudo cambiar el estado de la tarea.');
      }
    }
  }
};
</script>
