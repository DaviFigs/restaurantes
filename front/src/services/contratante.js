import { api } from './api.js'

export function cadastrarContratante(dados) {
    return api(
        'cadastrar_contratante',
        dados
    )
}