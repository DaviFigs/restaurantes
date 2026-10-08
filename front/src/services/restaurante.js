import { api } from './api.js'

export async function cadastrar_restaurante(dados, head = {}) {
    return await api('cadastrar_restaurante', dados, head)
}

export const cadastrarRestaurante = cadastrar_restaurante

