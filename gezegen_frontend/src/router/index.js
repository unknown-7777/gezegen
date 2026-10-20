import { createRouter, createWebHistory } from 'vue-router'
import Home   from '../views/Home.vue'
import Cities from '../views/Cities.vue'
import Hotels from '../views/Hotels.vue'
import Rooms  from '../views/Rooms.vue'

const routes = [
  { path: '/',       component: Home },
  { path: '/cities', component: Cities },
  { path: '/hotels', component: Hotels },
  { path: '/rooms', component:  Rooms },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})
