import { api } from './api.js'

export function autenticar(restaurante, usuario, senha) {

    return api(
        'autenticacao',
        {
            restaurante,
            usuario,
            senha
        },
        {
            chave: ''
        }
    )
}


export function cadastrarUsuarioMaster(dados){
    return api(
        'cadastrar_usuario_master',
        dados
    )
}