<?php

/**
 * Configuração principal da aplicação
 */

// ============================================================
// AMBIENTE
// ============================================================

define('ENVIRONMENT', 'development');

define('DEBUG', ENVIRONMENT === 'development');


// ============================================================
// CAMINHOS DO PROJETO
// ============================================================

define('BASE_PATH', dirname(__DIR__));

define('CONFIG_PATH', BASE_PATH . '/config');
define('API_PATH', BASE_PATH . '/api');
define('CONTROLLER_PATH', BASE_PATH . '/controllers');
define('MODEL_PATH', BASE_PATH . '/models');
define('SERVICE_PATH', BASE_PATH . '/services');
define('ROUTE_PATH', BASE_PATH . '/routes');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('STORAGE_PATH', BASE_PATH . '/storage');
define('LOG_PATH', STORAGE_PATH . '/logs');


// ============================================================
// URL DA API
// ============================================================

define('API_URL', 'http://localhost:8000');


// ============================================================
// FRONTEND
// ============================================================

define('FRONTEND_URL', 'http://localhost:5173');


// ============================================================
// BANCO DE DADOS
// ============================================================

define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'meu_banco');
define('DB_USER', 'postgres');
define('DB_PASS', 'senha');


// ============================================================
// CONFIGURAÇÕES DA APLICAÇÃO
// ============================================================

define('APP_NAME', 'Minha API');

define('APP_VERSION', '1.0.0');

define('TIMEZONE', 'America/Campo_Grande');

date_default_timezone_set(TIMEZONE);


// ============================================================
// DEBUG / ERROS
// ============================================================

if (DEBUG) {

    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');

    error_reporting(E_ALL);

} else {

    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');

    error_reporting(0);
}


// ============================================================
// HEADERS DA API
// ============================================================

header('Content-Type: application/json; charset=utf-8');

header(
    'Access-Control-Allow-Origin: ' . FRONTEND_URL
);

header(
    'Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS'
);

header(
    'Access-Control-Allow-Headers: Content-Type, Authorization'
);


// ============================================================
// CORS - PREFLIGHT
// ============================================================

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {

    http_response_code(204);

    exit;
}