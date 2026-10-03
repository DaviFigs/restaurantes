import { createRouter, createWebHistory } from 'vue-router'

import Login from '../views/usuario/login.vue'
import Cadastro from '../views/cadastro_usuario_master.vue'
import LoginMaster from '../views/usuario_master/login_master.vue'
import Home from '../views/home.vue'

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
        path: '/login_master',
        name: 'login_master',
        component: LoginMaster
    },
    {
        path: '/cadastro',
        name: 'cadastro',
        component: Cadastro
    },
    {
        path : '/home',
        name : 'home',
        component : Home

    }

]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router