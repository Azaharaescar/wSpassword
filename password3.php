<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Password generator - SOAP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/simple.css">
</head>

<body>
    <h1>Password Generator - SOAP</h1>
    <?php

    /**
     * SOAP es más complejo pero permite llamar métodos remotos
     * como si fueran funciones locales
     */

    echo "<h2>Consumo mediante SOAP</h2>";

    // Crear cliente SOAP en modo non-WSDL
    $client = new SoapClient(null, array(
        'uri' => 'http://localhost/desarrolloServidor/Tema7/ws-password/password-server.php',
        'location' => 'http://localhost/desarrolloServidor/Tema7/ws-password/password-server.php',
        'soap_version' => SOAP_1_2,
        'trace' => 1
    ));

    try {
        echo "<h3>Ejemplo 1: Generar una contraseña</h3>";

        $params = new StdClass();
        $params->length = 16;
        $params->useNumbers = true;
        $params->useSymbols = true;
        $params->useUppercase = true;

        $response = $client->generatePassword($params);

        echo "<p>Your password: <strong>" . htmlspecialchars($response['password']) . "</strong></p>";
        echo "<p>Length: " . $response['length'] . " characters</p>";

        echo "<hr>";
        echo "<h3>Ejemplo 2: Generar múltiples contraseñas</h3>";

        $params2 = new StdClass();
        $params2->count = 3;
        $params2->length = 12;
        $params2->useNumbers = true;
        $params2->useSymbols = false;
        $params2->useUppercase = true;

        $response2 = $client->generateMultiple($params2);

        echo "<p>Your passwords:</p>";
        echo "<ol>";
        foreach ($response2['passwords'] as $pwd) {
            echo "<li><strong>" . htmlspecialchars($pwd) . "</strong></li>";
        }
        echo "</ol>";
    } catch (SoapFault $fault) {
        echo "<p style='color: red;'>Error SOAP: " . $fault->faultcode . " - " . $fault->getMessage() . "</p>";
    }

    echo "<hr>";
    echo "<p><a href='index.php'>← Volver al índice</a></p>";

    ?>
</body>

</html>
echo "<p><a href='index.php'>← Volver al índice</a></p>";

pageBottom('Enero 2026');