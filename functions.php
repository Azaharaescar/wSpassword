<?php

/**
 * IES Virgen del Carmen de Jaén
 * Desarrollo Web en Entorno Servidor 2º DAW
 */

function pageTop($title)
{
    print "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>$title</title>
    <!-- Simple.css https://simplecss.org/ was created by Kev Quirk and is licensed under the MIT license. -->
    <link rel='stylesheet' href='css/simple.css'>
</head>
<body>
<h1>$title</h1>" . PHP_EOL;
}

function pageBottom($date = "Enero 2026")
{
    print "<footer>
<pre>
Desarrollo Web en Entorno Servidor 2º DAW 
IES Virgen del Carmen de Jaén
last modification: $date</pre>
<p><a href='https://simplecss.org/'>Simple.css</a> was created by Kev Quirk and is licensed under the MIT license.</p>
</footer>
</body>
</html>";
}
