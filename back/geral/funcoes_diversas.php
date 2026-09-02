<?php

require_once __DIR__ . '/../phpConfig.php';
require_once BASE_PATH . '/database/conexao.php';


function gerar_chave_aleatoria($tamanho = 32)
{
    return bin2hex(random_bytes($tamanho / 2));
}
function salvar_token($token, $id_restaurante, $id_usuario)
{
    try {
        $pdo = Conexao::getInstance();

        $stmt = $pdo->prepare('INSERT INTO tokens (token, id_restaurante, id_usuario) VALUES (:token, :id_restaurante, :id_usuario)');
        $stmt->execute([
            ':token' => $token,
            ':id_restaurante' => $id_restaurante,
            ':id_usuario' => $id_usuario,
        ]);

        return true;
    } catch (PDOException $e) {
        error_log('Erro ao salvar token: ' . $e->getMessage());
        return false;
    }
}   

function buscar_dados_via_chave($chave){
    try{
        $sql = "SELECT u.id_usuario, u.nome, r.id_restaurante, r.nome AS nome_restaurante, t.token, t.validade
                FROM usuarios u
                JOIN tokens t ON u.id_usuario = t.id_usuario
                JOIN restaurantes r ON u.id_restaurante = r.id_restaurante
                WHERE t.token = :chave AND t.validade > NOW()";
        $statement = Conexao::getInstance()->prepare($sql);
        $statement->bindParam(':chave', $chave, PDO::PARAM_STR);    
        $statement->execute();
        $dados = $statement->fetch(PDO::FETCH_ASSOC);
        if($statement->rowCount() === 0){
            throw new Exception("Nenhum usuário encontrado para a chave fornecida.");
        }
        return [
            'dados_usuario' => $dados,
            'registros' => $statement->rowCount(),
            'erro' => 0
        ];

    }
    catch(Exception $e)
    {
        error_log('Erro ao buscar usuário via chave: ' . $e->getMessage());
        return [
            'dados' => null,
            'registros' => 0,
            'erro' => 1
        ];
    }
}