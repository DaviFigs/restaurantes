<?php

require_once __DIR__ . '/../phpConfig.php';
require_once BASE_PATH . '/database/conexao.php';

class Usuario
{
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
            }

            return [
                'info' => [
                    [
                        'registros' => 1,
                        'cdg_erro'  => 0,
                        'msg'       => 'Usuário salvo com sucesso'
                    ]
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
}
