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
                $dsn = sprintf(
                    'pgsql:host=%s;port=%s;dbname=%s;user=%s;password=%s',
                    DB_HOST,
                    DB_PORT,
                    DB_NAME,
                    DB_USER,
                    DB_PASS
                );

                self::$instance = new PDO(
                    $dsn,
                    DB_USER,
                    DB_PASS,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                die('Erro de conexão com o PostgreSQL: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
