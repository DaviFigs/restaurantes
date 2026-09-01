<?php

require_once __DIR__ . '/../phpConfig.php';
require_once BASE_PATH . '/database/conexao.php';
require_once BASE_PATH . '/geral/funcoes_diversas.php';

class Usuario
{
        function autenticar_usuario($params){
        try{

            $sql = "SELECT u.id_usuario, u.nome, r.id_restaurante, r.nome AS nome_restaurante
                    FROM usuarios u
                    JOIN restaurantes r ON u.id_restaurante = r.id_restaurante
                    WHERE u.username = :username AND u.senha = :senha AND r.login_restaurante = :login_restaurante";
            $statement = Conexao::getInstance()->prepare($sql);
            $statement->bindParam(':username', $params['username'], PDO::PARAM_STR);
            $statement->bindParam(':senha', $params['senha'], PDO::PARAM_STR);
            $statement->bindParam(':login_restaurante', $params['login_restaurante'], PDO::PARAM_STR);
            $statement->execute();
            $dados = $statement->fetch(PDO::FETCH_ASSOC);
            if($statement->rowCount() === 0){
                throw new Exception("Usuário ou senha inválidos.");
            }
            $chave_de_acesso = gerar_chave_aleatoria();
            salvar_token($chave_de_acesso, $dados['id_restaurante'], $dados['id_usuario']);
            $dados['chave_de_acesso'] = $chave_de_acesso;
            return [
                'dados' => $dados,
                'registros' => $statement->rowCount(),
                'cdg_erro' => 0,
                'msg' => 'Autenticação realizada com sucesso'
            ];
        }catch(Exception $e){
            return [
                'dados' => [],
                'registros' => 0,
                'cdg_erro' => 1,
                'msg' => $e->getMessage()
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
