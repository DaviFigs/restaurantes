<?php

require_once __DIR__ . '/../phpConfig.php';
require_once BASE_PATH . '/models/Usuario.class.php';
require_once BASE_PATH . '/models/Restaurante.class.php';
require_once BASE_PATH . '/models/UsuarioMaster.class.php';
require_once BASE_PATH . '/models/Comanda.class.php';
require_once BASE_PATH . '/models/Produto.class.php';
require_once BASE_PATH . '/models/Lancamento.class.php';
require_once BASE_PATH . 'geral/funcoes_diversas.php';


function cadastrar_usuario_master($params){
        //parametros de cadastro de pessoa e cadastro de endereço

        $Ousuario_master = new UsuarioMaster();
        $res = $Ousuario_master->cadastrar_usuario_master($params);
        return $res;
    
}

function login_usuario_master($params){
        
        $Ousuario_master = new UsuarioMaster();
        $res = $Ousuario_master->login_usuario_master($params);

        $_SESSION['id_usuario_master'] = $res['dados']['id_usuario_master'];
        $_SESSION['nome_usuario_master'] = $res['dados']['nome_completo'];
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

    salva_ultima_sessao($res['dados']['id_usuario']);
    //salva o login no banco de dados
    return $res;

}

function logout($params)
{
    // Limpa todas as variáveis de sessão
    $_SESSION = [];

    // Destroi a sessão
    session_destroy();

    return [
        'info' => [
            [
                'registros' => 1,
                'cdg_erro'  => 0,
                'msg'       => 'Logout realizado com sucesso'
            ]
        ]
    ];
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
    $oProduto = new Produto();
    $res = $oProduto->buscar_produto($params);
    return $res;
    
}

function prep_excluir_produto($params)
{
    $oProduto = new Produto();
    $res = $oProduto->excluir_produto($params);
    return $res;

}

function prep_abrir_comanda($params)
{
    $oComanda= new Comanda();
    $res = $oComanda->abrir_comanda($params);
    return $res;
}

function prep_fechar_comanda($params)
{
    $oComandas = new Comanda();
    $res = $oComandas->fechar_comanda($params);
    return $res;
}

function prep_listar_comandas($params)
{
    if(isset($params['data_abertura'])) {
        $params['data_abertura'] = converter_data_postgres($params['data_abertura']);
    }
    $oComandas = new Comanda();
    $res = $oComandas->listar_comandas($params);
    return $res;
}

function prep_trazer_dados_comanda($params)
{
    $oComandas = new Comanda();
    $res = $oComandas->trazer_dados_comanda($params);
    return $res;
}

function prep_buscar_comanda($params)
{
    $oComandas = new Comanda();
    $res = $oComandas->buscar_comanda($params);
    return $res;
}




