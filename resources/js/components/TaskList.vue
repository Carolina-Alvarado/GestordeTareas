<template>
  <div>
    <h2 class="mb-4 text-center">Gestión de Tareas</h2>

    <!-- Formulario para crear una nueva tarea -->
    <div class="card mb-4">
      <div class="card-header">Nueva Tarea</div>
      <div class="card-body">
        <form @submit.prevent="crearTarea">
          <div class="form-group">
            <label>Título</label>
            <input v-model="nuevaTarea.titulo" class="form-control" required />
          </div>

          <div class="form-group">
            <label>Descripción</label>
            <textarea v-model="nuevaTarea.descripcion" class="form-control" required></textarea>
          </div>

          <div class="form-group">
            <label>Prioridad</label>
            <select v-model="nuevaTarea.prioridad" class="form-control" required>
              <option disabled value="">Seleccione una prioridad</option>
              <option value="baja">Baja</option>
              <option value="media">Media</option>
              <option value="alta">Alta</option>
            </select>
          </div>

          <div class="form-group">
            <label>Fecha de Vencimiento</label>
            <input type="date" v-model="nuevaTarea.fecha_vencimiento" class="form-control" required />
          </div>

          <button class="btn btn-primary mt-2">Crear Tarea</button>
        </form>
      </div>
    </div>

    <!-- Filtro -->
    <div class="mb-3">
      <label>Filtrar por prioridad:</label>
      <select v-model="filtroPrioridad" @change="filtrarTareas" class="form-control w-50">
        <option value="">Todas</option>
        <option value="baja">Baja</option>
        <option value="media">Media</option>
        <option value="alta">Alta</option>
      </select>
    </div>

    <!-- Lista de Tareas -->
    <div v-if="tareasFiltradas.length">
      <div v-for="tarea in tareasFiltradas" :key="tarea.id" class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
          <strong>{{ tarea.titulo }}</strong>
          <span :class="estadoClase(tarea.estado)">
            {{ tarea.estado === 'completada' ? '✅ Completada' : '⏳ Pendiente' }}
          </span>
        </div>
        <div class="card-body">
          <p><strong>Descripción:</strong> {{ tarea.descripcion }}</p>
          <p><strong>Prioridad:</strong> {{ tarea.prioridad }}</p>
          <p><strong>Fecha de Vencimiento:</strong> {{ tarea.fecha_vencimiento }}</p>

          <div class="mb-2">
            <button class="btn btn-sm btn-success mr-2" @click="cambiarEstado(tarea.id)">Cambiar Estado</button>
            <button class="btn btn-sm btn-danger" @click="eliminarTarea(tarea.id)">Eliminar</button>
          </div>

          <!-- Comentarios -->
          <div>
            <h6>Comentarios</h6>
            <ul class="list-group mb-2">
              <li v-for="comentario in tarea.comentarios" :key="comentario.id" class="list-group-item">
                {{ comentario.comentario }}
              </li>
            </ul>
            <div class="input-group">
              <input
                v-model="comentariosPorTarea[tarea.id]"
                placeholder="Escribe un comentario..."
                class="form-control"
              />
              <div class="input-group-append">
                <button class="btn btn-outline-primary" @click="agregarComentario(tarea.id)">Agregar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <p>No hay tareas para mostrar.</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tareas: [],
      filtroPrioridad: '',
      nuevaTarea: {
        titulo: '',
        descripcion: '',
        prioridad: 'media',
        fecha_vencimiento: '',
      },
      comentariosPorTarea: {},
    };
  },
  computed: {
    tareasFiltradas() {
      if (!this.filtroPrioridad) return this.tareas;
      return this.tareas.filter(t => t.prioridad === this.filtroPrioridad);
    }
  },
  mounted() {
    this.obtenerTareas();
  },
  methods: {
    async obtenerTareas() {
      try {
        const response = await fetch(`http://localhost:8000/api/tasklist`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
          },
          credentials: 'include',
        });
        if (response.ok) {
          this.tareas = await response.json();
        } else {
          console.error('Error al obtener tareas', await response.text());
        }
      } catch (err) {
        console.error('Fallo al conectarse al servidor:', err);
      }
    },

    async crearTarea() {
      try {
        const response = await fetch('http://localhost:8000/api/tasklist', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
          },
          credentials: 'include',
          body: JSON.stringify(this.nuevaTarea),
        });

        if (response.ok) {
          this.nuevaTarea = { titulo: '', descripcion: '', prioridad: 'media', fecha_vencimiento: '' };
          await this.obtenerTareas();
        } else {
          console.error('Error al crear tarea', await response.text());
        }
      } catch (err) {
        console.error('Error de red:', err);
      }
    },

    async cambiarEstado(id) {
      try {
        const response = await fetch(`http://localhost:8000/api/tasklist/${id}/estado`, {
          method: 'PATCH',
          credentials: 'include',
        });
        if (response.ok) {
          await this.obtenerTareas();
        } else {
          console.error('Error al cambiar estado');
        }
      } catch (err) {
        console.error(err);
      }
    },

    async eliminarTarea(id) {
      try {
        const response = await fetch(`http://localhost:8000/api/tasklist/${id}`, {
          method: 'DELETE',
          credentials: 'include',
        });
        if (response.ok) {
          this.tareas = this.tareas.filter(t => t.id !== id);
        } else {
          console.error('Error al eliminar tarea');
        }
      } catch (err) {
        console.error(err);
      }
    },

    async agregarComentario(tareaId) {
      const texto = this.comentariosPorTarea[tareaId];
      if (!texto.trim()) return;

      try {
        const response = await fetch(`http://localhost:8000/api/tasklist/${tareaId}/comentarios`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ comentario: texto }),
          credentials: 'include',
        });

        if (response.ok) {
          this.comentariosPorTarea[tareaId] = '';
          await this.obtenerTareas();
        } else {
          console.error('Error al agregar comentario');
        }
      } catch (err) {
        console.error(err);
      }
    },

    filtrarTareas() {
      // No necesitas volver a llamar a la API si ya tienes todas las tareas.
      // Esta función solo forza el `computed` a re-evaluarse.
    },

    estadoClase(estado) {
      return estado === 'completada' ? 'text-success' : 'text-warning';
    },
  },
};
</script>

<style scoped>
.card-header span {
  font-size: 0.9rem;
}
</style>
