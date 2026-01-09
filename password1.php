<?php

/**
 * Cliente GET - Generador de Contraseñas
 * Basado en test-add-get.php del Tema 7
 * 
 * HTTP GET es la forma más fácil de consumir un web service:
 * - Llamar a una URL
 * - Añadir parámetros
 * - Procesar la salida
 */

require_once 'functions.php';

pageTop('Cliente GET - Generador de Contraseñas');

echo "<h2>Consumo mediante HTTP GET</h2>";

// Obtener parámetros de la URL (si existen)
$length = 16;
if (isset($_GET['length'])) {
    $length = intval($_GET['length']);
}

$useNumbers = true;
if (isset($_GET['useNumbers'])) {
    $useNumbers = ($_GET['useNumbers'] === '1');
}

$useSymbols = true;
if (isset($_GET['useSymbols'])) {
    $useSymbols = ($_GET['useSymbols'] === '1');
}

$useUppercase = true;
if (isset($_GET['useUppercase'])) {
    $useUppercase = ($_GET['useUppercase'] === '1');
}

// Construir la URL del servicio con los parámetros
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

$serviceUrl = 'http://localhost/desarrolloServidor/Tema7/ws-password/password-service.php?'
    . 'length=' . $length
    . '&useNumbers=' . $useNumbersStr
    . '&useSymbols=' . $useSymbolsStr
    . '&useUppercase=' . $useUppercaseStr;

echo "<h3>Resultado</h3>";

// Usar file_get_contents para llamar a la URL
$response = file_get_contents($serviceUrl);

if ($response === false) {
    echo "<p style='color: red;'>Error: No se pudo conectar con el servicio</p>";
} else {
    // Decodificar el JSON recibido
    $data = json_decode($response, true);

    if ($data && $data['status'] === 'success') {
        $passwordData = $data['data'];

        echo "<p>Your password: <strong>" . htmlspecialchars($passwordData['password']) . "</strong></p>";
        echo "<p>Length: " . $passwordData['length'] . " characters</p>";
    } else {
        echo "<p style='color: red;'>Error en la respuesta del servicio</p>";
    }
}

// Formulario para probar con diferentes parámetros
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