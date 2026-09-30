// src/services/restaurante.js

import { api } from './api.js'

export async function cadastrarRestaurante(dados) {

    return await api(
        'cadastrar_restaurante',
        dados
    )

}

