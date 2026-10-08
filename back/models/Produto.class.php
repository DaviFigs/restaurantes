<?php
require_once __DIR__ . '/../phpConfig.php';
require_once BASE_PATH . '/database/conexao.php';

class Produto{

    function salvar_produto($params){
        
        $pdo = Conexao::getInstance();
        try {
            $pdo->beginTransaction();

            if($params['produto_id'] > 0){
                $sql = "UPDATE produto SET nome = :nome, descricao = :descricao, preco = :preco, restaurante_id = :restaurante_id WHERE id = :produto_id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':nome' => $params['nome'],
                    ':descricao' => $params['descricao'],
                    ':preco' => $params['preco'],
                    ':restaurante_id' => $params['restaurante_id'],
                    ':produto_id' => $params['produto_id']
                ]);

                if ($stmt->rowCount() == 0) {
                    throw new PDOException("Erro ao atualizar produto");
                }
            } else
            
            {
                $sql = "INSERT INTO produto (nome, descricao, preco, restaurante_id) VALUES (:nome, :descricao, :preco, :restaurante_id)";
                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    ':nome' => $params['nome'],
                    ':descricao' => $params['descricao'],
                    ':preco' => $params['preco'],
                    ':restaurante_id' => $params['restaurante_id']
                ]);
                if ($stmt->rowCount() == 0) {
                    throw new PDOException("Erro ao cadastrar produto");
                }
            }

            // Confirma a operação
            $pdo->commit();
            return [
                "info"=>[
                    "registros"=>1,
                    "cdg_erro"=>0,
                    "msg"=>"Produto salvo com sucesso"
                ],
                "dados"=>[
                    "produto_id"=>$params['produto_id'] > 0 ? $params['produto_id'] : $pdo->lastInsertId()
                ]
            ];

        } catch (PDOException $e) {
            // Desfaz a transação em caso de erro
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
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

    function excluir_produto($params){
        $pdo = Conexao::getInstance();
        try {
            $pdo->beginTransaction();

            $sql = "DELETE FROM produto WHERE id = :produto_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':produto_id' => $params['produto_id']
            ]);

            if ($stmt->rowCount() == 0) {
                throw new PDOException("Erro ao excluir produto");
            }

            // Confirma a operação
            $pdo->commit();
            return [
                'info' => [
                    [
                        'registros' => 1,
                        'cdg_erro'  => 0,
                        'msg'       => 'Produto excluído com sucesso'
                    ]
                ]
            ];

        } catch (PDOException $e) {
            // Desfaz a transação em caso de erro
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
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

    function buscar_produto($params){
        $pdo = Conexao::getInstance();
        try {

            $sql = "SELECT * FROM produto WHERE id = :produto_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':produto_id' => $params['produto_id']
            ]);

            if ($stmt->rowCount() == 0) {
                throw new PDOException("Produto não encontrado");
            }

            // Confirma a operação
            $dados_produto = $stmt->fetch(PDO::FETCH_ASSOC);
            return [
                'info' => [
                    [
                        'registros' => 1,
                        'cdg_erro'  => 0,
                        'msg'       => 'Produto encontrado com sucesso'
                    ],
                'dados' => $dados_produto
                ]
            ];

        } catch (PDOException $e) {
            // Desfaz a transação em caso de erro
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
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
    
}