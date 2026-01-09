<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Password generator - POST</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/simple.css">
</head>

<body>
    <h1>Password Generator - HTTP POST</h1>
    <?php

    /**
     * CLIENTE POST - Consumir el servicio con HTTP POST
     * 
     * POST es más complejo que GET pero más potente
     * Basado en test-add-post.php del Tema 7
     * http://free-web-services.com/tutorial.html
     * 
     * POST = los datos van en el BODY (no en la URL)
     * Se usa cURL para hacer peticiones POST con JSON
     */

    echo "<h2>Consumo mediante HTTP POST</h2>";

    // ========== 1. Leer parámetros del formulario ==========
    $length = 20;
    if (isset($_POST['length'])) {
        $length = intval($_POST['length']);
    }

    $count = 1;  // Número de contraseñas a generar
    if (isset($_POST['count'])) {
        $count = intval($_POST['count']);
    }

    // Los checkboxes solo aparecen en $_POST si están marcados
    $useNumbers = false;
    if (isset($_POST['useNumbers'])) {
        $useNumbers = true;
    }

    $useSymbols = false;
    if (isset($_POST['useSymbols'])) {
        $useSymbols = true;
    }

    $useUppercase = false;
    if (isset($_POST['useUppercase'])) {
        $useUppercase = true;
    }

    // ========== 2. Si hay datos POST, hacer la petición ==========
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<h3>Resultado</h3>";

        // ========== 3. Crear el objeto con los parámetros ==========
        // StdClass es una clase vacía de PHP para crear objetos simples
        $obj = new StdClass();
        $obj->length = $length;
        $obj->useNumbers = $useNumbers;
        $obj->useSymbols = $useSymbols;
        $obj->useUppercase = $useUppercase;
        $obj->count = $count;

        // ========== 4. Convertir a JSON ==========
        // json_encode convierte el objeto PHP a texto JSON
        $jsonData = json_encode($obj);

        // ========== 5. Configurar cURL ==========
        // cURL es una librería para hacer peticiones HTTP avanzadas
        // Es necesario para POST porque file_get_contents solo hace GET
        $ch = curl_init();  // Iniciar cURL

        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/desarrolloServidor/Tema7/ws-password/password-service.php');
        curl_setopt($ch, CURLOPT_POST, true);  // Método POST
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Devolver la respuesta como string
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);  // Los datos a enviar

        // Headers: le digo al servidor que estoy enviando JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        // ========== 6. Ejecutar la petición ==========
        $response = curl_exec($ch);  // Hacer la petición
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);  // Obtener código HTTP (200, 404, etc)
        curl_close($ch);  // Cerrar cURL

        // ========== 7. Procesar la respuesta ==========
        if ($httpStatus == 200) {  // 200 = OK
            // Decodificar el JSON recibido
            $data = json_decode($response, true);

            if ($data && $data['status'] === 'success') {
                $passwordData = $data['data'];

                // Verificar si son múltiples contraseñas
                if (isset($passwordData['passwords'])) {
                    // Es un array de contraseñas
                    echo "<p>Your passwords:</p>";
                    echo "<ol>";
                    foreach ($passwordData['passwords'] as $pwd) {
                        echo "<li><strong>" . htmlspecialchars($pwd) . "</strong></li>";
                    }
                    echo "</ol>";
                } else {
                    // Es una sola contraseña
                    echo "<p>Your password: <strong>" . htmlspecialchars($passwordData['password']) . "</strong></p>";
                    echo "<p>Length: " . $passwordData['length'] . " characters</p>";
                }
            } else {
                echo "<p style='color: red;'>Error en la respuesta del servicio</p>";
            }
        } else {
            echo "<p style='color: red;'>Error HTTP " . $httpStatus . "</p>";
        }

        echo "<hr>";
    }

    // ========== 8. Formulario ==========
    echo "<h3>Generar contraseña con POST</h3>";
    echo "<form method='POST' action='password2.php'>";

    echo "<p>";
    echo "<label><strong>Longitud:</strong></label><br>";
    echo "<input type='number' name='length' value='$length' min='4' max='64' style='padding: 5px; width: 100px;'>";
    echo "</p>";

    echo "<p>";
    echo "<label><strong>Cantidad de contraseñas:</strong></label><br>";
    echo "<input type='number' name='count' value='$count' min='1' max='10' style='padding: 5px; width: 100px;'>";
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
    echo "<button type='submit' style='background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;'>Generar con POST</button>";
    echo "</p>";
    echo "</form>";

    echo "<hr>";
    echo "<p><a href='index.php'>← Volver al índice</a></p>";

    ?>
</body>

</html>