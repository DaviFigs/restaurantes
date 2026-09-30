import { createRouter, createWebHistory } from 'vue-router'

import Login from '../views/usuario/login.vue'
import NovoContratante from '../views/contratante/novo_contratante.vue'
import CadastroRestaurante from '../views/restaurante/cadastro_restaurante.vue'

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
        path: '/contratante/cadastro',
        name: 'contratante-cadastro',
        component: NovoContratante
    },

    {
        path: '/restaurante/cadastro',
        name: 'restaurante-cadastro',
        component: CadastroRestaurante
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router