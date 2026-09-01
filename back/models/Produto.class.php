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

        } catch (PDOException $e) {
            // Desfaz a transação em caso de erro
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw new Exception("Erro ao salvar produto: " . $e->getMessage());
        }
    }

    function exclui_produto($params){
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

        } catch (PDOException $e) {
            // Desfaz a transação em caso de erro
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw new Exception("Erro ao excluir produto: " . $e->getMessage());
        }
    }
    
}