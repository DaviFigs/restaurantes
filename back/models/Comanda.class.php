<?php

require_once __DIR__ . '/../phpConfig.php';
require_once BASE_PATH . '/database/conexao.php';

class Comanda
{
     function abrir_comanda($params){
          $pdo = Conexao::getInstance();
          try
          {
               //verificar se não há comanda n aberta no mesmo dia com o mesmo nome de cliente
               $sql_verifica = "SELECT * FROM comanda 
               WHERE id_restaurante = " . $params['id_restaurante'] . " AND nome_cliente = '" . $params['nome_cliente'] . "' 
               AND fechada = false AND data_abertura = '" . $params['data_abertura'] . "' AND fechada = false";
               $stmt_verifica = $pdo->prepare($sql_verifica);
               $stmt_verifica->execute();
               if($stmt_verifica->rowCount() > 0){
                    throw new PDOException("Já existe uma comanda aberta para um cliente com o mesmo nome");
               }

               $sql = "INSERT INTO comanda (id_usuario,id_restaurante,nome_cliente,data_abertura,hora_abertura) VALUES (:id_usuario, :id_restaurante, UPPER(:nome_cliente), CURRENT_DATE, CURRENT_TIME)";
               $stmt = $pdo->prepare($sql);
               $stmt->execute([
                    ':id_usuario' => $params['id_usuario'],
                    ':id_restaurante' => $params['id_restaurante'],
                    ':nome_cliente' => $params['nome_cliente']
               ]);
               if ($stmt->rowCount() == 0) {
                    throw new PDOException("Erro ao abrir comanda");
               }
               return [
                    'dados' => [
                         'id_comanda' => $pdo->lastInsertId(),
                         'id_usuario' => $params['id_usuario'],
                         'id_restaurante' => $params['id_restaurante'],
                         'nome_cliente' => $params['nome_cliente']
                    ],
                    'registros' => 1,
                    'cdg_erro' => 0,
                    'msg' => 'Comanda aberta com sucesso'
               ];
          }
          catch(PDOException $e)
          {
               return [
                    'dados' => [],
                    'registros' => 0,
                    'cdg_erro' => 1,
                    'msg' => $e->getMessage()
               ];
          }
     }

     function adicionar_produto($params){
          $pdo = Conexao::getInstance();
          try
          {
               $sql = "INSERT INTO comanda_produto (id_comanda, id_produto, data_hora) VALUES (:id_comanda, :id_produto, NOW())";
               $stmt = $pdo->prepare($sql);
               $stmt->execute([
                    ':id_comanda' => $params['id_comanda'],
                    ':id_produto' => $params['id_produto']
               ]);
               if ($stmt->rowCount() == 0) {
                    throw new PDOException("Erro ao adicionar produto à comanda");
               }
               return [
                    'dados' => [
                         'id_comanda' => $params['id_comanda'],
                         'id_produto' => $params['id_produto']
                    ],
                    'registros' => 1,
                    'cdg_erro' => 0,
                    'msg' => 'Produto adicionado à comanda com sucesso'
               ];
          }
          catch(PDOException $e)
          {
               return [
                    'dados' => [],
                    'registros' => 0,
                    'cdg_erro' => 1,
                    'msg' => $e->getMessage()
               ];
          }
     }

     function remover_produto($params){
          $pdo = Conexao::getInstance();
          try
          {
               $sql = "DELETE FROM comanda_produto WHERE id_comanda = :id_comanda AND id_produto = :id_produto AND id = :id_comanda_produto";
               $stmt = $pdo->prepare($sql);
               $stmt->execute([
                    ':id_comanda' => $params['id_comanda'],
                    ':id_produto' => $params['id_produto'],
                    ':id_comanda_produto' => $params['id_comanda_produto']
               ]);
               if ($stmt->rowCount() == 0) {
                    throw new PDOException("Erro ao remover produto da comanda");
               }
               return [
                    'dados' => [
                         'id_comanda' => $params['id_comanda'],
                         'id_produto' => $params['id_produto']
                    ],
                    'registros' => 1,
                    'cdg_erro' => 0,
                    'msg' => 'Produto removido da comanda com sucesso'
               ];
          }
          catch(PDOException $e)
          {
               return [
                    'dados' => [],
                    'registros' => 0,
                    'cdg_erro' => 1,
                    'msg' => $e->getMessage()
               ];
          }
     }

     function buscar_comanda($params)
     {
          $pdo = Conexao::getInstance();
          try
          {
               $where = "WHERE 1=1 AND id_restaurante = " . $params['id_restaurante'];
               if($params['nome_cliente']){
                    $nome = $params['nome_cliente'];
                    $where .= "AND UPPER(nome_cliente) LIKE '%" . strtoupper($nome) . "%' ";
               }
               if($params['data_abertura']){
                    $data = $params['data_abertura'];
                    $where .= "AND data_abertura = $data ";

               }
               if($params['num_mesa']){
                    $num_mesa = $params['num_mesa'];
                    $where .= "AND num_mesa = $num_mesa ";
               }
               $where .= "ORDER BY data_abertura DESC, hora_abertura DESC"; 
               $sql = "SELECT * FROM comanda " . $where;
               $stmt = $pdo->prepare($sql);
               $stmt->execute();
               $comandas = $stmt->fetchAll(PDO::FETCH_ASSOC);
               if (!$comandas) {
                    throw new PDOException("Comanda não encontrada");
               }
               return [
                    'dados' => $comandas,
                    'registros' => count($comandas),
                    'cdg_erro' => 0,
                    'msg' => 'Comanda encontrada com sucesso'
               ];
          }
          catch(PDOException $e)
          {
               return [
                    'dados' => [],
                    'registros' => 0,
                    'cdg_erro' => 1,
                    'msg' => $e->getMessage()
               ];
          }
     }

     

}