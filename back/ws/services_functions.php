<?php

require_once __DIR__ . '/../phpConfig.php';
require_once BASE_PATH . '/models/Usuario.class.php';
require_once BASE_PATH . '/models/Restaurante.class.php';
require_once BASE_PATH . '/models/Comanda.class.php';
require_once BASE_PATH . '/models/Produto.class.php';
require_once BASE_PATH . '/models/Lancamento.class.php';

function autenticacao($params)
{
    try {
        $oUsuario = new Usuario();
        $res = $oUsuario->autenticar_usuario($params);
        if ($res['registros'] === 0) {
            throw new Exception('Usuário ou senha inválidos.');
        }
        return $res;
    } catch (Exception $e) {
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
        $oUsuario = new Usuario();
        $res = $oUsuario->salvar_usuario($params);
        if ($res['info']['registros'] === 0) {
            throw new Exception('Erro ao salvar usuário');
        }

        return $res;
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
        $oUsuario = new Usuario();
        $usuarios = $oUsuario->listar_usuarios($params);
        if($usuarios['info']['registros'] === 0){
            throw new Exception('Nenhum usuário encontrado');
        }

        return $usuarios;
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
        $oUsuario = new Usuario();
        $res = $oUsuario->buscar_usuario($params);
        if($res['info']['registros'] === 0){
            throw new Exception('Usuário não encontrado');
        }
        $retorno = $res;

        return $retorno;
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

function prep_salvar_produto($params)
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

function prep_listar_produtos($params)
{
    try {
        // TODO: Lógica para listar produtos

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

function prep_buscar_produto($params)
{
    try {
        // TODO: Lógica para buscar produto

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

function prep_excluir_produto($params)
{
    try {
        // TODO: Lógica para excluir produto

        return [
            'info' => [
                [
                    'registros' => 1,
                    'cdg_erro'  => 0,
                    'msg'       => 'Produto excluído com sucesso'
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

function prep_abrir_comanda($params)
{
    try {
        // TODO: Lógica para abrir comanda  

        return [
            'info' => [
                [
                    'registros' => 1,
                    'cdg_erro'  => 0,
                    'msg'       => 'Comanda aberta com sucesso'
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


function prep_listar_comandas($params)
{
    try {
        // TODO: Lógica para listar comandas

        return [
            'info' => [
                [
                    'registros' => 1,
                    'cdg_erro'  => 0,
                    'msg'       => 'Comandas listadas com sucesso'
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

function prep_buscar_comanda($params)
{
    try {
        // TODO: Lógica para buscar comanda

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


function prep_excluir_comanda($params)
{
    try {
        // TODO: Lógica para excluir comanda

        return [
            'info' => [
                [
                    'registros' => 1,
                    'cdg_erro'  => 0,
                    'msg'       => 'Comanda excluída com sucesso'
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


function prep_fechar_comanda($params)
{
    try {
        // TODO: Lógica para fechar comanda

        return [
            'info' => [
                [
                    'registros' => 1,
                    'cdg_erro'  => 0,
                    'msg'       => 'Comanda fechada com sucesso'
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

