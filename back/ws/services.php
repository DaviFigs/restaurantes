<?php

ob_start();



header('Content-Type: application/json; charset=utf-8');

// Em desenvolvimento:
// Troque pela URL real do seu Vue.
// Em produção, NUNCA use "*".
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');


/*
|--------------------------------------------------------------------------
| PREFLIGHT CORS
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

session_start();

require_once __DIR__ . '/../phpConfig.php';
require_once __DIR__ . '/services_functions.php';
require_once BASE_PATH . '/geral/funcoes_diversas.php';


/*
|--------------------------------------------------------------------------
| CONFIGURAÇÃO
|--------------------------------------------------------------------------
*/

$servicos_sem_auth = [
    'autenticacao',
    'cadastrar_contratante'

];


$retorno = [
    'info' => [
        [
            'registros' => 0,
            'cdg_erro'  => 0,
            'msg'       => ''
        ]
    ]
];


function erro_api(string $mensagem, int $codigo = 400): void
{
    http_response_code($codigo);

    throw new Exception($mensagem, $codigo);
}



try {


    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        erro_api('Método HTTP não permitido.', 405);
    }


    $json = file_get_contents('php://input');

    if (empty($json)) {
        erro_api('Corpo da requisição vazio.', 400);
    }


    /*
    |--------------------------------------------------------------------------
    | DECODIFICA JSON
    |--------------------------------------------------------------------------
    */

    $request = json_decode($json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        erro_api(
            'JSON inválido: ' . json_last_error_msg(),
            400
        );
    }

    if (!isset($request['dados']) || !is_array($request['dados'])) {
        erro_api('Estrutura de requisição inválida.', 400);
    }

    $request = $request['dados'];
    if (
        !isset($request['head']) ||
        !is_array($request['head'])
    ) {
        erro_api('Cabeçalho da requisição não informado.', 400);
    }


    /*
    |--------------------------------------------------------------------------
    | IDENTIFICA SERVIÇO
    |--------------------------------------------------------------------------
    */

    if (
        !isset($request['head']['servico']) ||
        !is_string($request['head']['servico']) ||
        empty($request['head']['servico'])
    ) {
        erro_api('Serviço não informado.', 400);
    }

    $servico = $request['head']['servico'];


    /*
    |--------------------------------------------------------------------------
    | VALIDA DATA
    |--------------------------------------------------------------------------
    */

    if (
        !isset($request['data']) ||
        !is_array($request['data'])
    ) {
        erro_api('Dados da requisição não informados.', 400);
    }

    $dados = $request['data'];


    /*
    |--------------------------------------------------------------------------
    | AUTENTICAÇÃO
    |--------------------------------------------------------------------------
    |
    | Serviços públicos não precisam de sessão.
    |
    | Serviços protegidos obtêm a identidade do usuário
    | EXCLUSIVAMENTE através da sessão.
    |
    */

    if (!in_array($servico, $servicos_sem_auth, true)) {

        $id_usuario = $_SESSION['id_usuario'] ?? null;
        $id_restaurante = $_SESSION['id_restaurante'] ?? null;


        /*
        |--------------------------------------------------------------------------
        | VERIFICA SE EXISTE SESSÃO
        |--------------------------------------------------------------------------
        */

        if (empty($id_usuario) || empty($id_restaurante)) {
            erro_api('Usuário não autenticado.', 401);
        }


        /*
        |--------------------------------------------------------------------------
        | BUSCA DADOS DO USUÁRIO
        |--------------------------------------------------------------------------
        */

        $dados_usuario = buscar_dados_usuario(
            $id_usuario,
            $id_restaurante
        );


        /*
        |--------------------------------------------------------------------------
        | VERIFICA SE O USUÁRIO EXISTE
        |--------------------------------------------------------------------------
        */

        if (
            !isset($dados_usuario['registros']) ||
            $dados_usuario['registros'] === 0
        ) {
            erro_api('Dados do usuário não encontrados.', 401);
        }


        /*
        |--------------------------------------------------------------------------
        | INJETA DADOS CONFIÁVEIS
        |--------------------------------------------------------------------------
        |
        | Esses dados vêm do servidor/sessão,
        | e não do Vue.
        |
        */

        $dados['id_usuario'] = $id_usuario;
        $dados['id_restaurante'] = $id_restaurante;

        $dados['usuario'] = $dados_usuario['dados_usuario'];
    }


    /*
    |--------------------------------------------------------------------------
    | ROTAS / SERVIÇOS
    |--------------------------------------------------------------------------
    */

    $rotas = [

        'autenticacao'
            => 'autenticacao',
        'cadastrar_contratante'
            => 'cadastrar_contratante',

        'salvar_usuario'
            => 'prep_salvar_usuario',

        'listar_usuarios'
            => 'prep_listar_usuarios',

        'buscar_usuario'
            => 'prep_buscar_usuario',

        'excluir_usuario'
            => 'prep_excluir_usuario',

        'cadastrar_restaurante'
            => 'prep_cadastrar_restaurante',

        'salvar_restaurante'
            => 'prep_salvar_restaurante',

        'listar_restaurantes'
            => 'prep_listar_restaurantes',

        'buscar_restaurante'
            => 'prep_buscar_restaurante',

        'excluir_restaurante'
            => 'prep_excluir_restaurante',

        'salvar_produto'
            => 'prep_salvar_produto',

        'listar_produtos'
            => 'prep_listar_produtos',

        'buscar_produto'
            => 'prep_buscar_produto',

        'excluir_produto'
            => 'prep_excluir_produto',

        'abrir_comanda'
            => 'prep_abrir_comanda',

        'listar_comandas'
            => 'prep_listar_comandas',

        'buscar_comanda'
            => 'prep_buscar_comanda',

        'excluir_comanda'
            => 'prep_excluir_comanda',

        'fechar_comanda'
            => 'prep_fechar_comanda'
    ];


    /*
    |--------------------------------------------------------------------------
    | VERIFICA SE O SERVIÇO EXISTE
    |--------------------------------------------------------------------------
    */

    if (!isset($rotas[$servico])) {
        erro_api('Requisição não encontrada.', 404);
    }


    /*
    |--------------------------------------------------------------------------
    | EXECUTA SERVIÇO
    |--------------------------------------------------------------------------
    */

    $funcao = $rotas[$servico];

    $retorno = $funcao($dados);//chama a função correspondente ao serviço solicitado dinamicamente


    /*
    |--------------------------------------------------------------------------
    | RESPOSTA
    |--------------------------------------------------------------------------
    */

    ob_clean();

    echo json_encode(
        $retorno,
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    );

    exit;

}


/*
|--------------------------------------------------------------------------
| TRATAMENTO DE ERROS
|--------------------------------------------------------------------------
*/

catch (Exception $e) {

    /*
    |--------------------------------------------------------------------------
    | Define HTTP 500 caso nenhum código tenha sido definido
    |--------------------------------------------------------------------------
    */

    $codigo = $e->getCode();

    if ($codigo < 400 || $codigo > 599) {
        $codigo = 500;
    }

    http_response_code($codigo);


    /*
    |--------------------------------------------------------------------------
    | Resposta de erro
    |--------------------------------------------------------------------------
    */

    $retorno = [
        'info' => [
            [
                'registros' => 0,
                'cdg_erro'  => $codigo,
                'msg'       => $e->getMessage()
            ]
        ]
    ];


    /*
    |--------------------------------------------------------------------------
    | Retorna JSON
    |--------------------------------------------------------------------------
    */

    ob_clean();

    echo json_encode(
        $retorno,
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    );

    exit;
}