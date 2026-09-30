<?php

require_once __DIR__ . '/../phpConfig.php';

class Conexao
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): PDO
{
    if (self::$instance === null) {

        try {

            $dsn = 'pgsql:host=localhost;port=5432;dbname=restaurantes';

            self::$instance = new PDO(
                $dsn,
                'postgres',
                'postgres',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );

        } catch (PDOException $e) {

            die(
                'Erro de conexão com o PostgreSQL: ' .
                $e->getMessage()
            );
        }
    }

    return self::$instance;
}
}
