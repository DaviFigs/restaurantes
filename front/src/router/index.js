import { createRouter, createWebHistory } from 'vue-router'

import Login from '../views/usuario/login.vue'
import Cadastro from '../views/cadastro_contratante_restaurante.vue'

const routes = [

    {
        path: '/',
        redirect: '/login'
    },

    {
        path: '/login',
        name: 'login',
        component: Login
    },

    {
        path: '/cadastro',
        name: 'cadastro',
        component: Cadastro
    }

]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router