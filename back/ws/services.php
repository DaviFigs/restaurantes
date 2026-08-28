<?php
ob_start();

header('Access-Control-Allow-Origin: *'); // Em produção, troque * pela URL do seu Vue
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json; charset=utf-8');

// 2. TRATAMENTO DO PREFLIGHT (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/funcoes.php';

$request = $_GET['request'] ?? '';

$dadosin = file_get_contents('php://input');

//buscar dados do restaurante, usuario, pela chave que irá vir

$retorno = [
    'info' => [
        [
            'registros' => 0,
            'cdg_erro'  => 0,
            'msg'       => ''
        ]
    ]
];

try {
    if (!empty($dadosin)) {
        $dados = json_decode($dadosin, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('JSON inválido: ' . json_last_error_msg());
        }
    }
    switch ($request) {
        case 'autenticacao':
            $retorno = call_user_func('autenticacao', $dados);
            break;

        case 'salvar_usuario':
            $retorno = call_user_func('prep_salvar_usuario', $dados);
            break;

        case 'listar_usuarios':
            $retorno = call_user_func('prep_listar_usuarios', $dados);
            break;

        case 'buscar_usuario':
            $retorno = call_user_func('prep_buscar_usuario', $dados);
            break;

        case 'excluir_usuario':
            $retorno = call_user_func('prep_excluir_usuario', $dados);
            break;

        case 'cadastrar_restaurante':
            $retorno = call_user_func('prep_cadastrar_restaurante', $dados);
            break;

        case 'salvar_restaurante':
            $retorno = call_user_func('prep_salvar_restaurante', $dados);
            break;

        case 'listar_restaurantes':
            $retorno = call_user_func('prep_listar_restaurantes', $dados);
            break;

        case 'buscar_restaurante':
            $retorno = call_user_func('prep_buscar_restaurante', $dados);
            break;

        case 'excluir_restaurante':
            $retorno = call_user_func('prep_excluir_restaurante', $dados);
            break;

        default:
            // Joga para o catch para reaproveitar a estrutura de erro
            throw new Exception('Requisição não encontrada', 404);
    }

    // Limpa qualquer "lixo" que tenha sido impresso acidentalmente antes do JSON
    ob_clean();
    echo json_encode(
        $retorno,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

} 
catch (Exception $e) 
{

    $retorno = [
        'info' => [
            [
                'registros' => 0,
                'cdg_erro'  => $e->getCode() ?: 1,
                'msg'       => $e->getMessage()
            ]
        ]
    ];
    // Garante que se houver erro, apenas o JSON do erro será enviado ao Vue
    ob_clean();
    echo json_encode(
        $retorno,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );
}