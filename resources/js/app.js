/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from "vue";
import VueRouter from 'vue-router'
import BootstrapVue from "bootstrap-vue"
import Home from "./components/App";
import AddPublication from "./components/AddPublicationForm";
import ShowPublication from "./components/ShowPublication";
import EditPublication from "./components/EditPublicationForm";

// import './../sass/app.scss';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(VueRouter);
Vue.use(BootstrapVue);

const routes = [
  { path: '/', component: Home },
  { path: '/add_publication', component: AddPublication },
  { path: '/publication/:id/edit', component: EditPublication, name: 'EditPublication' },
  { path: '/publication/:id', component: ShowPublication, name: 'ShowPublication' },
]

const router = new VueRouter({
  routes // short for `routes: routes`
})

const app = new Vue({
  router
}).$mount('#app')
