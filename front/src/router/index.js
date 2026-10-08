import { createRouter, createWebHistory } from 'vue-router'

import Login from '../views/usuario/login.vue'
import Cadastro from '../views/cadastro_usuario_master.vue'
import LoginMaster from '../views/usuario_master/login_master.vue'
import Home from '../views/home.vue'
import HomeMaster from '../views/usuario_master/home_master.vue'
import HomeComandas from '../views/comanda/home_comandas.vue'
import AbrirComanda from '../views/comanda/abrir_comanda.vue'
import Comanda from '../views/comanda/comanda.vue'
import CadastrarProduto from '../views/produto/cadastrar_produto.vue'
import RemoverProduto from '../views/produto/remover_produto.vue'
import CadastrarRestaurante from '../views/restaurante/cadastrar_restaurante.vue'

const routes = [

    {
        path: '/',
        redirect: '/login'
    },
    {
        path: '/cadastrar_restaurante',
        name: 'cadastrar_restaurante',
        component: CadastrarRestaurante
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { hideHeader: true }
    },
    {
        path: '/login_master',
        name: 'login_master',
        component: LoginMaster,
        meta: { hideHeader: true }
    },
    {
        path: '/cadastro',
        name: 'cadastro',
        component: Cadastro,
        meta: { hideHeader: true }
    },
    {
        path : '/home',
        name : 'home',
        component : Home

    },
    {
        path : '/home_master',
        name : 'home_master',
        component : HomeMaster

    },
    {
        path : '/cadastrar_produto',
        name : 'cadastrar_produto',
        component : CadastrarProduto

    }
    ,
    {
        path : '/remover_produto',
        name : 'remover_produto',
        component : RemoverProduto

    },
    {
        path : '/abrir_comanda',
        name : 'abrir_comanda',
        component : AbrirComanda

    },
    {
        path : '/home_comandas',
        name : 'home_comandas',
        component : HomeComandas

    },
    {
        path : '/comanda/:id',
        name : 'comanda',
        component : Comanda

    }

]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router