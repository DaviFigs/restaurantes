<?php


require_once __DIR__ . '/../phpConfig.php';
require_once BASE_PATH . '/database/conexao.php';

class Produto{

    function salvar_produto($params){
        
        try {
            $pdo = Conexao::getInstance();
            $pdo->beginTransaction();

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
    
}