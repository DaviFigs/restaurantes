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

            $p_endereco = $params['endereco'];
            $p_restaurante = $params['restaurante'];


            /*
            * ==========================
            * CADASTRA RESTAURANTE
            * ==========================
            */

            $sql_restaurante = "
                INSERT INTO restaurante
                (
                    id_usuario_master,
                    nome,
                    login_restaurante,
                    cpf_cnpj,
                    email,
                    telefone
                )
                VALUES
                (
                    :id_usuario_master,
                    :nome,
                    :login_restaurante,
                    :cpf_cnpj,
                    :email,
                    :telefone
                )
                RETURNING id
            ";

            $stmt_restaurante = $pdo->prepare($sql_restaurante);

            $stmt_restaurante->execute([
                ':id_usuario_master'    => $p_restaurante['id_usuario_master'],
                ':nome'              => $p_restaurante['nome'],
                ':login_restaurante' => $p_restaurante['login_restaurante'],
                ':cpf_cnpj'          => $p_restaurante['cpf_cnpj'],
                ':email'             => $p_restaurante['email'],
                ':telefone'          => $p_restaurante['telefone']
            ]);

            /*
            * O PostgreSQL retorna o ID criado
            * pelo RETURNING id.
            */
            $id_restaurante = $stmt_restaurante->fetchColumn();

            if (!$id_restaurante) {
                throw new RuntimeException(
                    'Erro ao cadastrar restaurante: ID não retornado.'
                );
            }


            /*
            * ==========================
            * CADASTRA ENDEREÇO
            * ==========================
            *
            * O endereço recebe o ID do
            * restaurante recém-criado.
            */

            $sql_endereco = "
                INSERT INTO endereco
                (
                    id_restaurante,
                    cep,
                    logradouro,
                    numero,
                    complemento,
                    bairro,
                    cidade,
                    estado
                )
                VALUES
                (
                    :id_restaurante,
                    :cep,
                    :logradouro,
                    :numero,
                    :complemento,
                    :bairro,
                    :cidade,
                    :estado
                )
                RETURNING id
            ";

            $stmt_endereco = $pdo->prepare($sql_endereco);

            $stmt_endereco->execute([
                ':id_restaurante' => $id_restaurante,
                ':cep'            => $p_endereco['cep'],
                ':logradouro'     => $p_endereco['logradouro'],
                ':numero'         => $p_endereco['numero'],
                ':complemento'    => $p_endereco['complemento'],
                ':bairro'         => $p_endereco['bairro'],
                ':cidade'         => $p_endereco['cidade'],
                ':estado'         => $p_endereco['estado']
            ]);

            /*
            * Pega o ID do endereço criado.
            */
            $id_endereco = $stmt_endereco->fetchColumn();

            if (!$id_endereco) {
                throw new RuntimeException(
                    'Erro ao cadastrar endereço: ID não retornado.'
                );
            }


            /*
            * ==========================
            * CONFIRMA TRANSAÇÃO
            * ==========================
            */

            $pdo->commit();


            /*
            * ==========================
            * RETORNO
            * ==========================
            */

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
                    'id_endereco'    => $id_endereco
                ]
            ];


        } catch (Throwable $e) {

            /*
            * Se restaurante ou endereço falhar,
            * desfaz toda a transação.
            */
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            error_log(
                'ERRO CADASTRAR RESTAURANTE: ' .
                $e->getMessage()
            );

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

    public function update_restaurante($params)
    {
        try {

            $pdo = Conexao::getInstance();

            $campos = [];
            $valores = [];

            /*
             * ==========================
             * CAMPOS PARA ATUALIZAÇÃO
             * ==========================
             */

            if (
                isset($params['nome']) &&
                $params['nome'] !== ''
            ) {
                $campos[] = 'nome_a = :nome_a';
                $valores[':nome_a'] = $params['nome'];
            }

            if (
                isset($params['cnpj']) &&
                $params['cnpj'] !== ''
            ) {
                $campos[] = 'cpf_cnpj = :cpf_cnpj';
                $valores[':cpf_cnpj'] = $params['cnpj'];
            }

            if (
                isset($params['telefone']) &&
                $params['telefone'] !== ''
            ) {
                $campos[] = 'telefone = :telefone';
                $valores[':telefone'] = $params['telefone'];
            }

            if (
                isset($params['email']) &&
                $params['email'] !== ''
            ) {
                $campos[] = 'email = :email';
                $valores[':email'] = $params['email'];
            }

            /*
             * ==========================
             * NENHUM CAMPO INFORMADO
             * ==========================
             */

            if (empty($campos)) {
                throw new RuntimeException(
                    'Nenhum campo para atualizar.'
                );
            }

            /*
             * ==========================
             * ID
             * ==========================
             */

            if (
                !isset($params['id']) ||
                $params['id'] === ''
            ) {
                throw new RuntimeException(
                    'ID do restaurante não informado.'
                );
            }

            $valores[':id'] = $params['id'];

            /*
             * ==========================
             * UPDATE
             * ==========================
             */

            $sql = "
                UPDATE restaurante
                SET " . implode(', ', $campos) . "
                WHERE id = :id
            ";

            $stmt = $pdo->prepare($sql);

            $stmt->execute($valores);

            /*
             * ==========================
             * VERIFICA ATUALIZAÇÃO
             * ==========================
             */

            if ($stmt->rowCount() === 0) {
                throw new RuntimeException(
                    'Nenhum restaurante foi atualizado. ' .
                    'Verifique se o ID existe ou se os valores foram alterados.'
                );
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

        } catch (Throwable $e) {

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


    public function listar_restaurantes($params){
        try{

            $pdo = Conexao::getInstance();
            $where = "WHERE 1=1 ";

            if($params['ativo']){
                $where .= 'AND ativo = '.$params['ativo'];
            }

            $sql = "SELECT * FROM restaurante $where ORDER BY data_criacao DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $restaurantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() === 0) {
                throw new Exception("Nenhum restaurante listado");}
            return [
                'info' => [
                    [
                        'registros' => count( $restaurantes ),
                        'cdg_erro'  => 0,
                        'msg'       => "Restaurantes Listados"
                    ]
                ],
                'dados'=> $restaurantes
            ];
            
        } catch (Throwable $e) {

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
    public function buscar_restaurante($params){
        try{

        }catch(Throwable $e) {
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