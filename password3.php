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
     * CLIENTE SOAP - Consumir el servicio con SOAP
     * 
     * SOAP es más complejo que GET/POST pero muy potente
     * Basado en test-add-soap.php y mycalculator-client.php del Tema 7
     * 
     * SOAP = protocolo formal que usa XML
     * Puedes llamar métodos remotos como si fueran funciones locales
     * Es como tener la clase PasswordGenerator en tu código pero ejecutándose en el servidor
     */

    echo "<h2>Consumo mediante SOAP</h2>";

    // ========== 1. Crear el cliente SOAP ==========
    // SoapClient es la clase de PHP para conectarse a servidores SOAP
    // Uso modo "non-WSDL" (sin archivo .wsdl) que es más simple
    $client = new SoapClient(null, array(
        'uri' => 'http://localhost/desarrolloServidor/Tema7/ws-password/password-server.php',
        'location' => 'http://localhost/desarrolloServidor/Tema7/ws-password/password-server.php',
        'soap_version' => SOAP_1_2,  // Versión de SOAP
        'trace' => 1  // Esto permite ver el XML que se envía/recibe
    ));

    try {
        // ========== 2. EJEMPLO 1: Generar UNA contraseña ==========
        echo "<h3>Ejemplo 1: Generar una contraseña</h3>";

        // Creo un objeto con los parámetros
        $params = new StdClass();
        $params->length = 16;
        $params->useNumbers = true;
        $params->useSymbols = true;
        $params->useUppercase = true;

        // ¡MAGIA! Llamo al método generatePassword() como si estuviera en mi código
        // Pero realmente se ejecuta en el servidor y se comunica por XML
        $response = $client->generatePassword($params);

        // Muestro el resultado
        echo "<p>Your password: <strong>" . htmlspecialchars($response['password']) . "</strong></p>";
        echo "<p>Length: " . $response['length'] . " characters</p>";

        // ========== 3. EJEMPLO 2: Generar MÚLTIPLES contraseñas ==========
        echo "<hr>";
        echo "<h3>Ejemplo 2: Generar múltiples contraseñas</h3>";

        $params2 = new StdClass();
        $params2->count = 3;  // Generar 3 contraseñas
        $params2->length = 12;
        $params2->useNumbers = true;
        $params2->useSymbols = false;  // Sin símbolos
        $params2->useUppercase = true;

        // Llamo a generateMultiple() - otro método del servidor
        $response2 = $client->generateMultiple($params2);

        // Muestro las contraseñas generadas
        echo "<p>Your passwords:</p>";
        echo "<ol>";
        foreach ($response2['passwords'] as $pwd) {
            echo "<li><strong>" . htmlspecialchars($pwd) . "</strong></li>";
        }
        echo "</ol>";

        // ========== 4. Manejo de errores SOAP ==========
    } catch (SoapFault $fault) {
        // Si algo falla en SOAP, lanzo un SoapFault
        echo "<p style='color: red;'>Error SOAP: " . $fault->faultcode . " - " . $fault->getMessage() . "</p>";
    }

    echo "<hr>";
    echo "<p><a href='index.php'>← Volver al índice</a></p>";

    ?>
</body>

</html>