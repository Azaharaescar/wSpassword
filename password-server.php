<?php

/**
 * Servidor SOAP para generación de contraseñas
 */

require_once 'PasswordGenerator.php';

// Configuración del servidor SOAP en modo non-WSDL
$options = array(
    'uri' => 'http://localhost/desarrolloServidor/Tema7/ws-password/password-server.php',
    'soap_version' => SOAP_1_2
);

$server = new SoapServer(null, $options);
$server->setClass('PasswordGenerator');
$server->handle();
