<?php

require_once __DIR__ . '/../phpConfig.php';
require_once BASE_PATH . '/database/conexao.php';
class  UsuarioMaster
{

    public function cadastrar_usuario_master($params)
    {
        $pdo = Conexao::getInstance();

        try {

            $pdo->beginTransaction();

            $p_usuario_master = $params['usuario_master'];
            $p_endereco = $params['endereco'];

            $sql_usuario_master = "
                INSERT INTO usuario_master
                (
                    nome_completo,
                    cpf_cnpj,
                    email,
                    telefone,
                    senha,
                    data_nascimento
                )
                VALUES
                (
                    :nome_completo,
                    :cpf_cnpj,
                    :email,
                    :telefone,
                    :senha,
                    :data_nascimento
                )
                RETURNING id
            ";

            $stmt_usuario_master = $pdo->prepare(
                $sql_usuario_master
            );

            $stmt_usuario_master->execute([
                ':nome_completo' =>
                    $p_usuario_master['nome_completo'],

                ':cpf_cnpj' =>
                    $p_usuario_master['cpf_cnpj'],

                ':email' =>
                    $p_usuario_master['email'],

                ':telefone' =>
                    $p_usuario_master['telefone'],

                ':senha' =>
                    password_hash(
                        $p_usuario_master['senha'],
                        PASSWORD_DEFAULT
                    ),

                ':data_nascimento' =>
                    $p_usuario_master['data_nascimento']
            ]);


            $id_usuario_master =
                $stmt_usuario_master->fetchColumn();


            if (!$id_usuario_master) {

                throw new RuntimeException(
                    'Erro ao cadastrar usuário master: ID não retornado.'
                );

            }



            $sql_endereco = "
                INSERT INTO endereco_master
                (
                    id_usuario_master,
                    cep,
                    logradouro,
                    numero,
                    complemento,
                    bairro,
                    cidade,
                    estado
                )
                VALUES
                (
                    :id_usuario_master,
                    :cep,
                    :logradouro,
                    :numero,
                    :complemento,
                    :bairro,
                    :cidade,
                    :estado
                )
                RETURNING id
            ";

            $stmt_endereco = $pdo->prepare(
                $sql_endereco
            );


            $stmt_endereco->execute([
                ':id_usuario_master' =>
                    $id_usuario_master,

                ':cep' =>
                    $p_endereco['cep'],

                ':logradouro' =>
                    $p_endereco['logradouro'],

                ':numero' =>
                    $p_endereco['numero'],

                ':complemento' =>
                    $p_endereco['complemento'],

                ':bairro' =>
                    $p_endereco['bairro'],

                ':cidade' =>
                    $p_endereco['cidade'],

                ':estado' =>
                    $p_endereco['estado']
            ]);

            $id_endereco =
                $stmt_endereco->fetchColumn();


            if (!$id_endereco) {

                throw new RuntimeException(
                    'Erro ao cadastrar endereço: ID não retornado.'
                );

            }


            $pdo->commit();

            return [

                'info' => [

                    [

                        'registros' => 1,

                        'cdg_erro' => 0,

                        'msg' =>
                            'Usuário master cadastrado com sucesso'

                    ]

                ],

                'dados' => [

                    'id_usuario_master' =>
                        $id_usuario_master,

                    'id_endereco' =>
                        $id_endereco

                ]

            ];


        } catch (Throwable $e) {

            if ($pdo->inTransaction()) {

                $pdo->rollBack();

            }


            error_log(
                'ERRO CADASTRAR USUARIO MASTER: ' .
                $e->getMessage()
            );


            return [

                'info' => [

                    [

                        'registros' => 0,

                        'cdg_erro' => 1,

                        'msg' => $e->getMessage()

                    ]

                ]

            ];

        }
    }

    public function login_usuario_master($params)
    {
        try {

            $pdo = Conexao::getInstance();

            // Busca o usuário apenas pelo e-mail
            $sql = "SELECT
                    um.id AS id_usuario_master,
                    um.nome_completo,
                    um.email,
                    um.senha,
                    r.id AS id_restaurante,
                    r.nome AS nome_restaurante
                FROM usuario_master um
                LEFT JOIN restaurante r ON um.id = r.id_usuario_master
                WHERE um.email = :email
            ";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':email' => $params['email']
            ]);

            $usuario_master = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica se o usuário existe e se a senha está correta
            if (
                !$usuario_master ||
                !password_verify(
                    $params['senha'],
                    $usuario_master['senha']
                )
            ) {

                return [
                    'info' => [
                        [
                            'registros' => 0,
                            'cdg_erro'  => 1,
                            'msg'       => 'Email ou senha inválidos'
                        ]
                    ]
                ];
            }

            // Login realizado com sucesso
            return [
                'info' => [
                    [
                        'registros' => 1,
                        'cdg_erro'  => 0,
                        'msg'       => 'Login bem-sucedido'
                    ]
                ],
                'dados' => [
                    'id_usuario_master' => $usuario_master['id_usuario_master'],
                    'nome_completo'     => $usuario_master['nome_completo'],
                    'email'             => $usuario_master['email'],
                    'restaurante'       => $usuario_master['id_restaurante'],
                ]
            ];

        } catch (PDOException $e) {

            return [
                'info' => [
                    [
                        'registros' => 0,
                        'cdg_erro'  => 1,
                        'msg'       => 'Erro ao realizar login :'. $e->getMessage()
                    ]
                ]
            ];
        }
    }

}