# Password Generator Web Service

Web Service con PHP que genera contraseñas aleatorias seguras.

## Características

-   Generar contraseñas aleatorias con longitud personalizable
-   Opciones para incluir números, símbolos y mayúsculas
-   Generar múltiples contraseñas a la vez
-   Consumible mediante **GET**, **POST** y **SOAP**

## Archivos del proyecto

-   **PasswordGenerator.php** - Clase con la lógica de generación de contraseñas
-   **password-service.php** - Endpoint REST que maneja peticiones GET/POST
-   **password-server.php** - Servidor SOAP
-   **password1.php** - Cliente HTTP GET
-   **password2.php** - Cliente HTTP POST con cURL
-   **password3.php** - Cliente SOAP

## Uso

### HTTP GET

```php
http://localhost/desarrolloServidor/Tema7/ws-password/password-service.php?length=16&useNumbers=true&useSymbols=true&useUppercase=true
```

### HTTP POST

```php
// Enviar JSON con cURL
{
  "length": 20,
  "useNumbers": true,
  "useSymbols": true,
  "useUppercase": true,
  "count": 5
}
```

### SOAP

```php
$client = new SoapClient(null, array(
    'uri' => 'http://localhost/.../password-server.php',
    'location' => 'http://localhost/.../password-server.php'
));

$params = new StdClass();
$params->length = 16;
$response = $client->generatePassword($params);
```

## Referencias

-   [http://free-web-services.com/tutorial.html](http://free-web-services.com/tutorial.html)
-   [https://github.com/roderik/pwgen-php](https://github.com/roderik/pwgen-php)
-   [PHP random_int()](https://www.php.net/manual/en/function.random-int.php)

## Práctica

**Desarrollo Web en Entorno Servidor - 2º DAW**  
IES Virgen del Carmen de Jaén
