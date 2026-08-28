<?php

/**
 * funcoes.php
 * Arquivo com as funções chamadas via call_user_func no services.php
 */

// ============================================================
// USUÁRIOS
// ============================================================

function autenticacao($params)
{
    try {
        

        return [
            'info' => [
                [
                    'registros' => 0,
                    'cdg_erro'  => 0,
                    'msg'       => 'Autenticação realizada com sucesso'
                ]
            ],
            'dados' => []
        ];
    } catch (Exception $e) {
        return [
            'info' => [
                [
                    'registros' => 0,
                    'cdg_erro'  => $e->getCode() ?: 1,
                    'msg'       => $e->getMessage()
                ]
            ]
        ];
    }
}

function prep_salvar_usuario($params)
{
    try {
        // TODO: Lógica para salvar/editar usuário

        return [
            'info' => [
                [
                    'registros' => 1,
                    'cdg_erro'  => 0,
                    'msg'       => 'Usuário salvo com sucesso'
                ]
            ]
        ];
    } catch (Exception $e) {
        return [
            'info' => [
                [
                    'registros' => 0,
                    'cdg_erro'  => $e->getCode() ?: 1,
                    'msg'       => $e->getMessage()
                ]
            ]
        ];
    }
}

function prep_listar_usuarios($params)
{
    try {
        // TODO: Lógica para listar usuários

        return [
            'info' => [
                [
                    'registros' => 0,
                    'cdg_erro'  => 0,
                    'msg'       => ''
                ]
            ],
            'dados' => []
        ];
    } catch (Exception $e) {
        return [
            'info' => [
                [
                    'registros' => 0,
                    'cdg_erro'  => $e->getCode() ?: 1,
                    'msg'       => $e->getMessage()
                ]
            ]
        ];
    }
}

function prep_buscar_usuario($params)
{
    try {
        // TODO: Lógica para buscar um usuário específico

        return [
            'info' => [
                [
                    'registros' => 0,
                    'cdg_erro'  => 0,
                    'msg'       => ''
                ]
            ],
            'dados' => []
        ];
    } catch (Exception $e) {
        return [
            'info' => [
                [
                    'registros' => 0,
                    'cdg_erro'  => $e->getCode() ?: 1,
                    'msg'       => $e->getMessage()
                ]
            ]
        ];
    }
}

function prep_excluir_usuario($params)
{
    try {
        // TODO: Lógica para excluir usuário

        return [
            'info' => [
                [
                    'registros' => 1,
                    'cdg_erro'  => 0,
                    'msg'       => 'Usuário excluído com sucesso'
                ]
            ]
        ];
    } catch (Exception $e) {
        return [
            'info' => [
                [
                    'registros' => 0,
                    'cdg_erro'  => $e->getCode() ?: 1,
                    'msg'       => $e->getMessage()
                ]
            ]
        ];
    }
}


// ============================================================
// RESTAURANTES
// ============================================================

function prep_cadastrar_restaurante($params)
{
    try {
        // TODO: Lógica para cadastrar restaurante

        return [
            'info' => [
                [
                    'registros' => 1,
                    'cdg_erro'  => 0,
                    'msg'       => 'Restaurante cadastrado com sucesso'
                ]
            ]
        ];
    } catch (Exception $e) {
        return [
            'info' => [
                [
                    'registros' => 0,
                    'cdg_erro'  => $e->getCode() ?: 1,
                    'msg'       => $e->getMessage()
                ]
            ]
        ];
    }
}

function prep_salvar_restaurante($params)
{
    try {
        // TODO: Lógica para salvar/atualizar restaurante

        return [
            'info' => [
                [
                    'registros' => 1,
                    'cdg_erro'  => 0,
                    'msg'       => 'Restaurante salvo com sucesso'
                ]
            ]
        ];
    } catch (Exception $e) {
        return [
            'info' => [
                [
                    'registros' => 0,
                    'cdg_erro'  => $e->getCode() ?: 1,
                    'msg'       => $e->getMessage()
                ]
            ]
        ];
    }
}

function prep_listar_restaurantes($params)
{
    try {
        // TODO: Lógica para listar restaurantes

        return [
            'info' => [
                [
                    'registros' => 0,
                    'cdg_erro'  => 0,
                    'msg'       => ''
                ]
            ],
            'dados' => []
        ];
    } catch (Exception $e) {
        return [
            'info' => [
                [
                    'registros' => 0,
                    'cdg_erro'  => $e->getCode() ?: 1,
                    'msg'       => $e->getMessage()
                ]
            ]
        ];
    }
}

function prep_buscar_restaurante($params)
{
    try {
        // TODO: Lógica para buscar um restaurante específico

        return [
            'info' => [
                [
                    'registros' => 0,
                    'cdg_erro'  => 0,
                    'msg'       => ''
                ]
            ],
            'dados' => []
        ];
    } catch (Exception $e) {
        return [
            'info' => [
                [
                    'registros' => 0,
                    'cdg_erro'  => $e->getCode() ?: 1,
                    'msg'       => $e->getMessage()
                ]
            ]
        ];
    }
}

function prep_excluir_restaurante($params)
{
    try {
        // TODO: Lógica para excluir restaurante

        return [
            'info' => [
                [
                    'registros' => 1,
                    'cdg_erro'  => 0,
                    'msg'       => 'Restaurante excluído com sucesso'
                ]
            ]
        ];
    } catch (Exception $e) {
        return [
            'info' => [
                [
                    'registros' => 0,
                    'cdg_erro'  => $e->getCode() ?: 1,
                    'msg'       => $e->getMessage()
                ]
            ]
        ];
    }
}