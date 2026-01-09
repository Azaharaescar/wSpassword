<?php

/**
 * SERVIDOR REST para generación de contraseñas
 * 
 * Este archivo maneja tanto GET como POST en el mismo sitio
 * Es como los ejemplos del profesor de http://free-web-services.com/tutorial.html
 * 
 * En REST es normal tener un solo endpoint que maneja varios métodos HTTP
 */

require_once 'PasswordGenerator.php';

// Le digo al navegador que voy a devolver JSON
header('Content-Type: application/json; charset=utf-8');

// Creo el generador de contraseñas
$generator = new PasswordGenerator();

// Miro si es GET o POST
// $_SERVER['REQUEST_METHOD'] me dice qué método HTTP están usando
$method = $_SERVER['REQUEST_METHOD'];

try {
    // ========== CASO 1: Petición GET ==========
    // Basado en test-add-get.php del Tema 7
    if ($method === 'GET') {
        // En GET los parámetros vienen en la URL: ?length=16&useNumbers=true...
        // $_GET es un array con todos los parámetros de la URL

        // Valores por defecto por si no me pasan nada
        $length = 12;
        if (isset($_GET['length'])) {
            $length = intval($_GET['length']);  // intval convierte a número
        }

        $useNumbers = true;
        if (isset($_GET['useNumbers'])) {
            // filter_var convierte "true"/"false" (string) a boolean
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

        // Creo un objeto con los parámetros
        $params = new StdClass();
        $params->length = $length;
        $params->useNumbers = $useNumbers;
        $params->useSymbols = $useSymbols;
        $params->useUppercase = $useUppercase;

        // Llamo a la clase para generar la contraseña
        $result = $generator->generatePassword($params);

        // Devuelvo el resultado en JSON
        // json_encode convierte el array PHP a texto JSON
        echo json_encode(array(
            'status' => 'success',
            'method' => 'GET',
            'data' => $result
        ));

        // ========== CASO 2: Petición POST ==========
        // Basado en test-add-post.php del Tema 7
    } else if ($method === 'POST') {
        // En POST los datos vienen en el body (no en la URL)
        // file_get_contents('php://input') lee el body de la petición
        $input = file_get_contents('php://input');

        // json_decode convierte el texto JSON a objeto PHP
        $data = json_decode($input);

        // Si no hay datos o no es JSON válido, uso valores por defecto
        if (!$data) {
            $data = new StdClass();
            $data->length = 12;
            $data->useNumbers = true;
            $data->useSymbols = true;
            $data->useUppercase = true;
            $data->count = 1;
        }

        // Si me piden más de una contraseña, uso generateMultiple
        if (isset($data->count) && $data->count > 1) {
            $result = $generator->generateMultiple($data);
        } else {
            $result = $generator->generatePassword($data);
        }

        // Devuelvo el resultado en JSON
        echo json_encode(array(
            'status' => 'success',
            'method' => 'POST',
            'data' => $result
        ));

        // ========== CASO 3: Método no soportado ==========
    } else {
        // Si usan PUT, DELETE u otro, devuelvo error 405
        http_response_code(405);
        echo json_encode(array(
            'status' => 'error',
            'message' => 'Método no permitido. Use GET o POST.'
        ));
    }

    // ========== Por si algo falla ==========
} catch (Exception $e) {
    // Si hay algún error, devuelvo error 500
    http_response_code(500);
    echo json_encode(array(
        'status' => 'error',
        'message' => $e->getMessage()
    ));
}
