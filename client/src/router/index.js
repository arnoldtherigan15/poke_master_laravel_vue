import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Register from '../views/Register.vue'
import Login from '../views/Login.vue'
import AddPokemon from '../views/AddPokemon.vue'
import EditPokemon from '../views/EditPokemon.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/register',
    name: 'Register',
    component: Register
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/add-pokemon',
    name: 'AddPokemon',
    component: AddPokemon
  },
  {
    path: '/edit/:id',
    name: 'EditPokemon',
    component: EditPokemon
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})
router.beforeEach((to, from, next) => {
  if(!localStorage.token && to.name != 'Login' && to.name != 'Register') {
    next({name: 'Login'})
  } else if((localStorage.token && to.name == 'Login') || (localStorage.token && to.name == 'Register')) {
    next({name:'Home'})
  } else {
    next()
  }
})

export default router
