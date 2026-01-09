<?php
include_once "functions.php";

pageTop("Password Generator Web Service");
?>
<p>Web Service que genera contraseñas aleatorias seguras.</p>

<h2>Consumir el servicio</h2>
<ul>
    <li><a href="password1.php" class="button">password1.php</a> - HTTP <strong>GET</strong>: La forma más fácil de consumir un web service. Los parámetros se envían en la URL.</li>
    <li><a href="password2.php" class="button">password2.php</a> - HTTP <strong>POST</strong>: Usando cURL para enviar datos JSON. Permite generar múltiples contraseñas.</li>
    <li><a href="password3.php" class="button">password3.php</a> - <strong>SOAP</strong>: Consumir el servicio mediante protocolo SOAP (Simple Object Access Protocol).</li>
</ul>

<h2>Archivos del proyecto</h2>
<ul>
    <li><strong>PasswordGenerator.php</strong> - Clase con la lógica de generación de contraseñas</li>
    <li><strong>password-service.php</strong> - Endpoint REST que maneja peticiones GET/POST</li>
    <li><strong>password-server.php</strong> - Servidor SOAP</li>
    <li><strong>functions.php</strong> - Funciones auxiliares para HTML</li>
</ul>

<h2>Características</h2>
<ul>
    <li>Generar contraseñas aleatorias con longitud personalizable</li>
    <li>Opciones para incluir números, símbolos y mayúsculas</li>
    <li>Generar múltiples contraseñas a la vez (POST)</li>
    <li>Verificar fortaleza de contraseñas (SOAP)</li>
    <li>Consumible mediante GET, POST y SOAP</li>
</ul>

<h2>Referencias</h2>
<ul>
    <li><a target="_blank" href="http://free-web-services.com/tutorial.html">http://free-web-services.com/tutorial.html</a></li>
    <li><a target="_blank" href="https://github.com/roderik/pwgen-php">https://github.com/roderik/pwgen-php</a></li>
</ul>

<?php
pageBottom();
