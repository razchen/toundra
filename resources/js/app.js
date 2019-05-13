
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import 'admin-lte/dist/js/adminlte.min.js';
import 'chart.js/dist/Chart.js';
import Form from './utilities/Form';
window.Form = Form;

window.Vue = require('vue');
window.admin = document.querySelector('meta[name="admin"]').getAttribute('content');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Cameras from './components/user/Cameras.vue';
import Scenes from './components/user/Scenes.vue';
import ControlDefinitions from './components/user/ControlDefinitions.vue';
import Reports from './components/user/Reports.vue';
import ThreeDs from './components/user/ThreeDs.vue';
import Users from './components/user/Users.vue';
import Protocols from './components/user/Protocols.vue';

const routes = [
  {
      name: 'cameras_index',
      path: '/cameras',
      component: Cameras,
      props: { method: 'index' }
  },
  {
      name: 'cameras_create',
      path: '/cameras/create',
      component: Cameras,
      props: { method: 'create' }
  },
  {
      name: 'cameras_edit',
      path: '/cameras/:id/edit',
      component: Cameras,
      props: { method: 'edit' }
  },
  {
      name: 'cameras_show',
      path: '/cameras/:id',
      component: Cameras,
      props: { method: 'show' }
  },
  
  {
      name: 'scenes_create',
      path: '/scenes/create',
      component: Scenes,
      props: { method: 'create' }
  },
  {
      name: 'scenes_edit',
      path: '/scenes/:id/edit',
      component: Scenes,
      props: { method: 'edit' }
  },
  {
      name: 'scenes_index',
      path: '/scenes',
      component: Scenes,
      props: { method: 'index' }
  },
  {
      name: 'scenes_show',
      path: '/scenes/:id',
      component: Scenes,
      props: { method: 'show' }
  },

  {
      name: 'control_definitions_create',
      path: '/control-definitions/create',
      component: ControlDefinitions,
      props: { method: 'create' }
  },
  {
      name: 'control_definitions_edit',
      path: '/control-definitions/:id/edit',
      component: ControlDefinitions,
      props: { method: 'edit' }
  },
  {
      name: 'control_definitions_index',
      path: '/control-definitions',
      component: ControlDefinitions,
      props: { method: 'index' }
  },
  {
      name: 'control_definitions_show',
      path: '/control-definitions/:id',
      component: ControlDefinitions,
      props: { method: 'show' }
  },

  {
      name: 'reports_create',
      path: '/reports/create',
      component: Reports,
      props: { method: 'create' }
  },
  {
      name: 'reports_edit',
      path: '/reports/:id/edit',
      component: Reports,
      props: { method: 'edit' }
  },
  {
      name: 'reports_index',
      path: '/reports',
      component: Reports,
      props: { method: 'index' }
  },
  {
      name: 'reports_show',
      path: '/reports/:id',
      component: Reports,
      props: { method: 'show' }
  },

  {
      name: 'three_d_create',
      path: '/models/create',
      component: ThreeDs,
      props: { method: 'create' }
  },
  {
      name: 'three_d_edit',
      path: '/models/:id/edit',
      component: ThreeDs,
      props: { method: 'edit' }
  },
  {
      name: 'three_d_index',
      path: '/models',
      component: ThreeDs,
      props: { method: 'index' }
  },
  {
      name: 'three_d_show',
      path: '/models/:id',
      component: ThreeDs,
      props: { method: 'show' }
  },

  {
      name: 'users_create',
      path: '/users/create',
      component: Users,
      props: { method: 'create' }
  },
  {
      name: 'users_edit',
      path: '/users/:id/edit',
      component: Users,
      props: { method: 'edit' }
  },
  {
      name: 'users_index',
      path: '/users',
      component: Users,
      props: { method: 'index' }
  },
  {
      name: 'users_show',
      path: '/users/:id',
      component: Users,
      props: { method: 'show' }
  },

  {
      name: 'protocols_create',
      path: '/protocols/create',
      component: Protocols,
      props: { method: 'create' }
  },
  {
      name: 'protocols_edit',
      path: '/protocols/:id/edit',
      component: Protocols,
      props: { method: 'edit' }
  },
  {
      name: 'protocols_index',
      path: '/protocols',
      component: Protocols,
      props: { method: 'index' }
  },
  {
      name: 'protocols_show',
      path: '/protocols/:id',
      component: Protocols,
      props: { method: 'show' }
  }
];

const router = new VueRouter({ mode: 'history', routes: routes});
const app = new Vue(Vue.util.extend({ router })).$mount('#app');
// const app = new Vue({
//     el: '#app'
// });