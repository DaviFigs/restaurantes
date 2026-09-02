<?php

require_once __DIR__ . '/../phpConfig.php';
require_once BASE_PATH . '/database/conexao.php';
require_once BASE_PATH . '/geral/funcoes_diversas.php';

class Usuario
{
    function autenticar_usuario($params)
    {
        try {
            $pdo = Conexao::getInstance();

            $sql = "SELECT 
                        u.id AS id_usuario,
                        u.nome,
                        r.id AS id_restaurante,
                        r.nome AS nome_restaurante
                    FROM usuario u
                    JOIN restaurante r ON u.id_restaurante = r.id
                    WHERE u.username = :username
                    AND u.senha = :senha
                    AND r.login_restaurante = :login_restaurante
                    AND u.ativo = 1
                    AND r.ativo = 1
                    LIMIT 1";

            $statement = $pdo->prepare($sql);

            $statement->execute([
                ':username' => $params['username'],
                ':senha' => $params['senha'],
                ':login_restaurante' => $params['login_restaurante']
            ]);

            $dados = $statement->fetch(PDO::FETCH_ASSOC);

            if (count($dados) === 0) {
                throw new Exception("Usuário ou senha inválidos.");
            }

            // Geração da chave aleatória
            do {
                $chave_de_acesso = gerar_chave_aleatoria();

                $sql = "SELECT 1
                        FROM tokens
                        WHERE token = :token
                        LIMIT 1";

                $statement_token = $pdo->prepare($sql);

                $statement_token->execute([
                    ':token' => $chave_de_acesso
                ]);

                $chave_valida = ($statement_token->fetchColumn() === false);

            } while (!$chave_valida);

            salvar_token(
                $chave_de_acesso,
                $dados['id_restaurante'],
                $dados['id_usuario']
            );

            $dados['chave_de_acesso'] = $chave_de_acesso;

            return [
                'info' => [
                    [
                        'registros' => 1,
                        'cdg_erro' => 0,
                        'msg' => 'Autenticação realizada com sucesso'
                    ]
                ],
                'dados' => $dados
            ];

        } catch (Exception $e) {
            return [
                'info' => [
                    [
                        'registros' => 0,
                        'cdg_erro' => 1,
                        'msg' => $e->getMessage()
                    ]
                ],
                'dados' => []
            ];
        }
    }

    public function salvar_usuario($params)
    {
        try {
            $pdo = Conexao::getInstance();

            //faz um update no usuário
            if($params['usuario_id']>0){
                $stmt = $pdo->prepare('UPDATE usuario SET nome = :nome, email = :email, senha = :senha, tipo = :tipo WHERE id = :usuario_id');
                $stmt->execute([
                    ':nome' => $params['nome'],
                    ':email' => $params['email'],
                    ':senha' => $params['senha'],
                    ':tipo' => $params['tipo'],
                    ':usuario_id' => $params['usuario_id'],
                ]);
                $id_usuario = $params['usuario_id'];
            }
            else
            {
                //cria novo usuário
                $stmt = $pdo->prepare('INSERT INTO usuario (nome, email, senha, tipo) VALUES (:nome, :email, :senha, :tipo)');
                $stmt->execute([
                    ':nome' => $params['nome'],
                    ':email' => $params['email'],
                    ':senha' => $params['senha'],
                    ':tipo' => $params['tipo'],
                ]);
                $id_usuario = $pdo->lastInsertId();
            }
            

            return [
                'info' => [
                    [
                        'registros' => 1,
                        'cdg_erro'  => 0,
                        'msg'       => 'Usuário salvo com sucesso',
                    ]
                ],
                'dados' =>[
                    'nome' => $params['nome'],
                    'email' => $params['email'],
                    'tipo' => $params['tipo'],
                    'id_usuario' => $id_usuario
                ]
                
            ];
        } catch (PDOException $e) {
            return [
                'info' => [
                    [
                        'registros' => 0,
                        'cdg_erro'  => 1,
                        'msg'       => 'Erro ao salvar usuário'
                    ]
                ]
            ];
        }
    }

    function listar_usuarios($params){
        try{
            $pdo = Conexao::getInstance();
            $sql = "SELECT id_usuario, nome, email, tipo FROM usuario WHERE id_restaurante = :id_restaurante";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':id_restaurante' => $params['id_restaurante']
            ]);
            $dados = $statement->fetchAll(PDO::FETCH_ASSOC);
            return [
                'info' => [
                    [
                        'registros' => $statement->rowCount(),
                        'cdg_erro'  => 0,
                        'msg'       => 'Usuários listados com sucesso'
                    ]
                ],
                'dados' => $dados
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

    function buscar_usuario($params){
        try{
            $where = "WHERE 1=1 ";
            if($params['id_usuario'] <= 0){
                throw new Exception("ID do usuário inválido.");
            }
            if($params['nome']){
                $where .= "AND nome = '". $params['nome']."' ";
            }
            if($params['email']){
                $where .= "AND email = '". $params['email']."' ";
            }
            if($params['tipo']){
                $where .= "AND tipo = '". $params['tipo']."' ";
            }
            if($params['id_usuario']){
                $where .= "AND id_usuario = '". $params['id_usuario']."' ";
            }
            $pdo = Conexao::getInstance();
            $sql = "SELECT id_usuario, nome, email, tipo FROM usuario " . $where;
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $dados = $statement->fetch(PDO::FETCH_ASSOC);
            return [
                'info' => [
                    [
                        'registros' => $statement->rowCount(),
                        'cdg_erro'  => 0,
                        'msg'       => 'Usuário buscado com sucesso'
                    ]
                ],
                'dados' => $dados
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
}
