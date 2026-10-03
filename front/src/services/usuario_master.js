import { api } from './api.js'

export function cadastrar_usuario_master(dados) {
    return api(
        'cadastrar_usuario_master',
        dados
    )
}

export function login_usuario_master(dados) {
    return api(
        'login_usuario_master',
        dados
    )
}