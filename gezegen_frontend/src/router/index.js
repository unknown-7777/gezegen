import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Hotels from '../views/Hotels.vue'
import Cities from '../views/Cities.vue'

const routes = [
  { path: '/',       component: Home },
  { path: '/hotels', component: Hotels },
  { path: '/cities', component: Cities },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})
