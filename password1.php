<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Password generator - GET</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/simple.css">
</head>

<body>
    <h1>Password Generator - HTTP GET</h1>
    <?php

    /**
     * CLIENTE GET - Consumir el servicio con HTTP GET
     * 
     * GET es la forma MÁS FÁCIL de consumir un web service
     * Basado en test-add-get.php del Tema 7
     * http://free-web-services.com/tutorial.html
     * 
     * GET = los parámetros van en la URL (visible)
     * Ejemplo: service.php?length=16&useNumbers=true
     */

    echo "<h2>Consumo mediante HTTP GET</h2>";

    // ========== 1. Leer parámetros del formulario ==========
    // Si el usuario ha enviado el formulario, los parámetros están en $_GET
    $length = 16;  // valor por defecto
    if (isset($_GET['length'])) {
        $length = intval($_GET['length']);  // intval convierte a número
    }

    $useNumbers = true;
    if (isset($_GET['useNumbers'])) {
        $useNumbers = ($_GET['useNumbers'] === '1');  // Si vale '1' es true
    }

    $useSymbols = true;
    if (isset($_GET['useSymbols'])) {
        $useSymbols = ($_GET['useSymbols'] === '1');
    }

    $useUppercase = true;
    if (isset($_GET['useUppercase'])) {
        $useUppercase = ($_GET['useUppercase'] === '1');
    }

    // ========== 2. Construir la URL del servicio ==========
    // Tengo que convertir los boolean a string 'true'/'false'
    $useNumbersStr = 'false';
    if ($useNumbers) {
        $useNumbersStr = 'true';
    }

    $useSymbolsStr = 'false';
    if ($useSymbols) {
        $useSymbolsStr = 'true';
    }

    $useUppercaseStr = 'false';
    if ($useUppercase) {
        $useUppercaseStr = 'true';
    }

    // Construyo la URL completa con todos los parámetros
    $serviceUrl = 'http://localhost/desarrolloServidor/Tema7/ws-password/password-service.php?'
        . 'length=' . $length
        . '&useNumbers=' . $useNumbersStr
        . '&useSymbols=' . $useSymbolsStr
        . '&useUppercase=' . $useUppercaseStr;

    echo "<h3>Resultado</h3>";

    // ========== 3. Llamar al servicio con file_get_contents ==========
    // file_get_contents es la forma más simple de hacer una petición GET
    // Es como abrir una URL en el navegador, pero desde PHP
    $response = file_get_contents($serviceUrl);

    if ($response === false) {
        echo "<p style='color: red;'>Error: No se pudo conectar con el servicio</p>";
    } else {
        // ========== 4. Procesar la respuesta JSON ==========
        // El servicio me devuelve JSON, así que tengo que decodificarlo
        // json_decode convierte el texto JSON a array PHP
        $data = json_decode($response, true);  // el 'true' lo convierte a array

        if ($data && $data['status'] === 'success') {
            $passwordData = $data['data'];

            // Muestro la contraseña generada
            echo "<p>Your password: <strong>" . htmlspecialchars($passwordData['password']) . "</strong></p>";
            echo "<p>Length: " . $passwordData['length'] . " characters</p>";
        } else {
            echo "<p style='color: red;'>Error en la respuesta del servicio</p>";
        }
    }

    // ========== 5. Formulario para probar con otros parámetros ==========
    echo "<hr>";
    echo "<h3>Probar con otros parámetros</h3>";
    echo "<form method='GET' action='password1.php'>";

    echo "<p>";
    echo "<label><strong>Longitud:</strong></label><br>";
    echo "<input type='number' name='length' value='$length' min='4' max='64' style='padding: 5px; width: 100px;'>";
    echo "</p>";

    echo "<p>";
    $checkedNum = '';
    if ($useNumbers) {
        $checkedNum = 'checked';
    }
    echo "<label><input type='checkbox' name='useNumbers' value='1' " . $checkedNum . "> Incluir números (0-9)</label>";
    echo "</p>";

    echo "<p>";
    $checkedSym = '';
    if ($useSymbols) {
        $checkedSym = 'checked';
    }
    echo "<label><input type='checkbox' name='useSymbols' value='1' " . $checkedSym . "> Incluir símbolos (!@#$...)</label>";
    echo "</p>";

    echo "<p>";
    $checkedUpp = '';
    if ($useUppercase) {
        $checkedUpp = 'checked';
    }
    echo "<label><input type='checkbox' name='useUppercase' value='1' " . $checkedUpp . "> Incluir mayúsculas (A-Z)</label>";
    echo "</p>";

    echo "<p>";
    echo "<button type='submit' style='background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;'>Generar Nueva Contraseña</button>";
    echo "</p>";
    echo "</form>";

    echo "<hr>";
    echo "<p><a href='index.php'>← Volver al índice</a></p>";

    ?>
</body>

</html>