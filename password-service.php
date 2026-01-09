<?php

/**
 * Endpoint REST para generación de contraseñas
 * Maneja peticiones GET y POST
 */

require_once 'PasswordGenerator.php';

header('Content-Type: application/json; charset=utf-8');

$generator = new PasswordGenerator();
$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        // Petición GET - parámetros en la URL
        $length = 12;
        if (isset($_GET['length'])) {
            $length = intval($_GET['length']);
        }

        $useNumbers = true;
        if (isset($_GET['useNumbers'])) {
            $useNumbers = filter_var($_GET['useNumbers'], FILTER_VALIDATE_BOOLEAN);
        }

        $useSymbols = true;
        if (isset($_GET['useSymbols'])) {
            $useSymbols = filter_var($_GET['useSymbols'], FILTER_VALIDATE_BOOLEAN);
        }

        $useUppercase = true;
        if (isset($_GET['useUppercase'])) {
            $useUppercase = filter_var($_GET['useUppercase'], FILTER_VALIDATE_BOOLEAN);
        }

        $params = new StdClass();
        $params->length = $length;
        $params->useNumbers = $useNumbers;
        $params->useSymbols = $useSymbols;
        $params->useUppercase = $useUppercase;

        $result = $generator->generatePassword($params);

        echo json_encode(array(
            'status' => 'success',
            'method' => 'GET',
            'data' => $result
        ));
    } else if ($method === 'POST') {
        // Petición POST - parámetros en el body JSON
        $input = file_get_contents('php://input');
        $data = json_decode($input);

        if (!$data) {
            $data = new StdClass();
            $data->length = 12;
            $data->useNumbers = true;
            $data->useSymbols = true;
            $data->useUppercase = true;
            $data->count = 1;
        }

        // Verificar si se solicitan múltiples contraseñas
        if (isset($data->count) && $data->count > 1) {
            $result = $generator->generateMultiple($data);
        } else {
            $result = $generator->generatePassword($data);
        }

        echo json_encode(array(
            'status' => 'success',
            'method' => 'POST',
            'data' => $result
        ));
    } else {
        http_response_code(405);
        echo json_encode(array(
            'status' => 'error',
            'message' => 'Método no permitido. Use GET o POST.'
        ));
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array(
        'status' => 'error',
        'message' => $e->getMessage()
    ));
}
