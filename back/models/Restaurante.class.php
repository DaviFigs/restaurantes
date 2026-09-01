<?php

require_once __DIR__ . '/../phpConfig.php';
require_once BASE_PATH . '/database/conexao.php';

class Restaurante
{



    public function cadastrar_restaurante($params)
    {
        $pdo = Conexao::getInstance();
        try {
            $pdo->beginTransaction();

            // Cadastra endereço
            $sql_endereco = "INSERT INTO endereco
                (logradouro, numero, complemento, bairro, cidade, estado, cep)
                VALUES
                (:logradouro, :numero, :complemento, :bairro, :cidade, :estado, :cep)";

            $stmt_endereco = $pdo->prepare($sql_endereco);

            $stmt_endereco->execute([
                ':logradouro' => $params['logradouro'],
                ':numero' => $params['numero'],
                ':complemento' => $params['complemento'],
                ':bairro' => $params['bairro'],
                ':cidade' => $params['cidade'],
                ':estado' => $params['estado'],
                ':cep' => $params['cep']
            ]);

            $id_endereco = $pdo->lastInsertId();

            // Cadastra restaurante
            $sql = "INSERT INTO restaurante
                (nome, cnpj, endereco, telefone, email, endereco_id)
                VALUES
                (:nome, :cnpj, :endereco, :telefone, :email, :endereco_id)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nome' => $params['nome'],
                ':cnpj' => $params['cnpj'],
                ':endereco' => $params['endereco'],
                ':telefone' => $params['telefone'],
                ':email' => $params['email'],
                ':endereco_id' => $id_endereco
            ]);

            $id_restaurante = $pdo->lastInsertId();

            if ($stmt->rowCount() == 0) {
                throw new PDOException("Erro ao cadastrar restaurante");
            }

            // Confirma as duas operações
            $pdo->commit();

            return [
                'info' => [
                    [
                        'registros' => 1,
                        'cdg_erro'  => 0,
                        'msg'       => 'Restaurante cadastrado com sucesso'
                    ]
                ],
                'dados' => [
                    'id_restaurante' => $id_restaurante,
                    'id_endereco' => $id_endereco
                ]
            ];

        } catch (PDOException $e) {

            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

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

    function update_restaurante($params){
        try{
            $campos = "";
            if($params['nome'] != ""){
                $campos .= "nome = '". $params['nome']."', ";
            }
            if($params['cnpj'] != ""){
                $campos .= "cnpj = '". $params['cnpj']."', ";
            }
            if($params['telefone'] != ""){
                $campos .= "telefone = '". $params['telefone']."', ";
            }
            if($params['email'] != ""){
                $campos .= "email = '". $params['email']."', ";
            }
            #tirar ultima virgula
            $campos = rtrim($campos, ", ");

            $pdo = Conexao::getInstance();
            $sql = "UPDATE restaurante SET $campos WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id' => $params['id']
            ]);
            if($stmt->rowCount() == 0){
                throw new PDOException("Erro ao atualizar restaurante");
            }

            return [
                'info' => [
                    [
                        'registros' => 1,
                        'cdg_erro'  => 0,
                        'msg'       => 'Restaurante atualizado com sucesso'
                    ]
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
