<?php

/**
 * Cliente POST - Generador de Contraseñas
 * Basado en test-add-post.php del Tema 7
 * 
 * HTTP POST con cURL:
 * - Enviar datos en formato JSON
 * - Usar cURL para configurar la petición
 * - Procesar la respuesta JSON
 */

require_once 'functions.php';

pageTop('Cliente POST - Generador de Contraseñas');

echo "<h2>Consumo mediante HTTP POST</h2>";

// Obtener parámetros del formulario (si existen)
$length = 20;
if (isset($_POST['length'])) {
    $length = intval($_POST['length']);
}

$count = 1;
if (isset($_POST['count'])) {
    $count = intval($_POST['count']);
}

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

// Si hay datos POST, hacer la petición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h3>Resultado</h3>";

    // Crear objeto con los parámetros
    $obj = new StdClass();
    $obj->length = $length;
    $obj->useNumbers = $useNumbers;
    $obj->useSymbols = $useSymbols;
    $obj->useUppercase = $useUppercase;
    $obj->count = $count;

    // Convertir a JSON
    $jsonData = json_encode($obj);

    // Configurar cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/desarrolloServidor/Tema7/ws-password/password-service.php');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData)
    ));

    // Ejecutar la petición
    $response = curl_exec($ch);
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpStatus == 200) {
        // Decodificar el JSON recibido
        $data = json_decode($response, true);

        if ($data && $data['status'] === 'success') {
            $passwordData = $data['data'];

            // Verificar si son múltiples contraseñas
            if (isset($passwordData['passwords'])) {
                echo "<p>Your passwords:</p>";
                echo "<ol>";
                foreach ($passwordData['passwords'] as $pwd) {
                    echo "<li><strong>" . htmlspecialchars($pwd) . "</strong></li>";
                }
                echo "</ol>";
            } else {
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

// Formulario
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