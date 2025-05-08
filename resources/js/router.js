import Vue from 'vue';
import Router from 'vue-router';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Dashboard from './components/Dashboard.vue';
import TaskList from './components/TaskList.vue';
import Task from './components/Task.vue';

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    { path: '/', redirect: '/login' },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    {
        path: '/',
        component: Dashboard,
        children: [
          {
            path: 'tasklist',
            name: 'tasklist',
            component: TaskList,
          },

          {
            path: 'task',
            name: 'task',
            component: Task,
          },
        ],
      },
  ]
});
