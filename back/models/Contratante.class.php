<?php

require_once __DIR__ . '/../phpConfig.php';
require_once BASE_PATH . '/database/conexao.php';

class Contratante
{

public function cadastrar_contratante($params){
        try{

            $pdo = Conexao::getInstance();
    
            $sql = "INSERT INTO contratante
            (nome_completo, cpf, email, telefone, senha)
            VALUES
            (:nome_completo, :cpf, :email, :telefone, :senha)
            RETURNING id
            ";
    
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nome_completo' => $params['nome_completo'],
                ':cpf' => $params['cpf'],
                ':email' => $params['email'],
                ':telefone' => $params['telefone'],
                ':senha' => password_hash($params['senha'], PASSWORD_DEFAULT)
            ]);
    
            $id_contratante = $stmt->fetchColumn();
    
            return [
                'info' => [
                    [
                        'registros' => 1,
                        'cdg_erro'  => 0,
                        'msg'       => 'Contratante cadastrado com sucesso'
                    ]
                ],
                'dados' => [
                    'id_contratante' => $id_contratante
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

}