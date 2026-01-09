<?php

/**
 * SERVIDOR SOAP para generación de contraseñas
 * 
 * Esto es diferente a REST (GET/POST)
 * SOAP usa XML en vez de JSON y es más formal
 * 
 * Lo saqué del ejemplo mycalculator-client.php del Tema 7
 * Usa modo "non-WSDL" que es más simple (no necesita archivo .wsdl)
 */

require_once 'PasswordGenerator.php';

// Configuración del servidor SOAP
// 'uri' es como el identificador del servicio
// 'soap_version' dice qué versión de SOAP usar (1.2 es la más nueva)
$options = array(
    'uri' => 'http://localhost/desarrolloServidor/Tema7/ws-password/password-server.php',
    'soap_version' => SOAP_1_2
);

// Creo el servidor SOAP
// El "null" significa que NO uso archivo WSDL (modo non-WSDL)
$server = new SoapServer(null, $options);

// Le digo al servidor SOAP que use la clase PasswordGenerator
// Esto hace que todos los métodos públicos de la clase estén disponibles por SOAP
$server->setClass('PasswordGenerator');

// Esto procesa las peticiones SOAP que llegan
// Lee el XML de la petición, llama al método y devuelve XML de respuesta
$server->handle();
