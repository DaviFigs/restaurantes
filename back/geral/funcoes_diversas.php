<?php

require_once __DIR__ . '/../phpConfig.php';
require_once BASE_PATH . '/database/conexao.php';
   

function buscar_dados_usuario($id_usuario, $id_restaurante){
    try{
        $sql = "SELECT u.id_usuario, u.nome as nome_usuario, r.id_restaurante, r.nome AS nome_restaurante, t.token, t.validade
                FROM usuarios u
                JOIN restaurantes r ON u.id_restaurante = r.id_restaurante
                WHERE u.id = :id_usuario and r.id = :id_restaurante";
        $statement = Conexao::getInstance()->prepare($sql);
        $statement->bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
        $statement->bindParam(':id_restaurante', $id_restaurante, PDO::PARAM_STR);
        $statement->execute();
        $dados = $statement->fetch(PDO::FETCH_ASSOC);
        if($statement->rowCount() === 0){
            throw new Exception("Nenhum usuário encontrado para o ID fornecido.");
        }
        return [
            'dados_usuario' => $dados,
            'registros' => $statement->rowCount(),
            'erro' => 0
        ];

    }
    catch(Exception $e)
    {
        error_log('Erro ao buscar usuário: ' . $e->getMessage());
        return [
            'dados' => null,
            'registros' => 0,
            'erro' => 1
        ];
    }
}