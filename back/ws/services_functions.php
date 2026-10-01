<?php

require_once __DIR__ . '/../phpConfig.php';
require_once BASE_PATH . '/models/Usuario.class.php';
require_once BASE_PATH . '/models/Contratante.class.php';
require_once BASE_PATH . '/models/Restaurante.class.php';
require_once BASE_PATH . '/models/Comanda.class.php';
require_once BASE_PATH . '/models/Produto.class.php';
require_once BASE_PATH . '/models/Lancamento.class.php';


function cadastrar_contratante($params){
        
        $oContratante = new Contratante();
        $res = $oContratante->cadastrar_contratante($params);
        return $res;
    
}
function autenticacao($params)
{
    $oUsuario = new Usuario();

    $res = $oUsuario->autenticar_usuario($params);

    if ($res['info'][0]['registros'] === 0) {
        throw new Exception('Usuário ou senha inválidos.');
    }

    // Usuário autenticado: gera um novo ID de sessão
    session_regenerate_id(true);

    $_SESSION['id_usuario'] = $res['dados']['id_usuario'];
    $_SESSION['id_restaurante'] = $res['dados']['id_restaurante'];
    $_SESSION['nome_usuario'] = $res['dados']['nome_usuario'];
    $_SESSION['nome_restaurante'] = $res['dados']['nome_restaurante'];

    return $res;

}

function prep_salvar_usuario($params)
{

    $oUsuario = new Usuario();
    $res = $oUsuario->salvar_usuario($params);
    if ($res['info']['registros'] === 0) {
        throw new Exception('Erro ao salvar usuário');
    }

    return $res;
    
}

function prep_listar_usuarios($params)
{

    $oUsuario = new Usuario();
    $usuarios = $oUsuario->listar_usuarios($params);
    if($usuarios['info']['registros'] === 0){
        throw new Exception('Nenhum usuário encontrado');
    }

    return $usuarios;

}

function prep_buscar_usuario($params)
{       
    $oUsuario = new Usuario();
    $res = $oUsuario->buscar_usuario($params);
    if($res['info']['registros'] === 0){
        throw new Exception('Usuário não encontrado');
    }
    $retorno = $res;

    return $retorno;

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
        $oRestaurante = new Restaurante();
        $res = $oRestaurante->cadastrar_restaurante($params);
        // TODO: Lógica para cadastrar restaurante

        return $res;
    
}

function prep_salvar_restaurante($params)
{
    $oRestaurante = new Restaurante();
    $res = $oRestaurante->update_restaurante($params);
    return $res;
}

function prep_listar_restaurantes($params)
{
    $oRestaurante = new Restaurante();
    $restaurantes = $oRestaurante->listar_restaurantes($params);
    return $restaurantes;
}

function prep_buscar_restaurante($params)
{
    $oRestaurante = new Restaurante();
    $restaurantes = $oRestaurante->buscar_restaurante($params);
    return $restaurantes;
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

