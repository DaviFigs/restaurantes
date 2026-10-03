<?php

require_once __DIR__ . '/../phpConfig.php';
require_once BASE_PATH . '/database/conexao.php';
class  UsuarioMaster
{

    public function cadastrar_usuario_master($params){
        try{

            $pdo = Conexao::getInstance();
    
            $sql = "INSERT INTO usuario_master
            (nome_completo, cpf, email, telefone, senha, data_nascimento)
            VALUES
            (:nome_completo, :cpf, :email, :telefone, :senha, :data_nascimento)
            RETURNING id
            ";
    
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nome_completo' => $params['nome_completo'],
                ':cpf' => $params['cpf'],
                ':email' => $params['email'],
                ':telefone' => $params['telefone'],
                ':senha' => password_hash($params['senha'], PASSWORD_DEFAULT),
                ':data_nascimento' => $params['data_nascimento']
            ]);
    
            $id_usuario_master = $stmt->fetchColumn();

    
            return [
                'info' => [
                    [
                        'registros' => 1,
                        'cdg_erro'  => 0,
                        'msg'       => 'usuario_master cadastrado com sucesso'
                    ]
                ],
                'dados' => [
                    'id_usuario_master' => $id_usuario_master
                ]
            ];
        }catch(PDOException $e){
            return [
                'info' => [
                    [
                        'registros' => 0,
                        'cdg_erro'  => 1,
                        'msg'       => $e->getMessage()
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
            $sql = "
                SELECT
                    id AS id_usuario_master,
                    nome_completo,
                    email,
                    senha
                FROM usuario_master
                WHERE email = :email
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
                    'email'             => $usuario_master['email']
                ]
            ];

        } catch (PDOException $e) {

            return [
                'info' => [
                    [
                        'registros' => 0,
                        'cdg_erro'  => 1,
                        'msg'       => 'Erro ao realizar login'
                    ]
                ]
            ];
        }
    }

}