<?php

/**
 * Clase generadora de contraseñas
 * 
 * Esta clase la saqué de los ejemplos del profesor:
 * - https://www.phpjabbers.com/generate-a-random-password-with-php-php70.html
 * - También usa ideas de https://hugh.blog/2012/04/23/simple-way-to-generate-a-random-password-in-php/
 * 
 * Lo importante es usar random_int() de PHP 7 porque es más seguro que rand()
 */
class PasswordGenerator
{
    // Este método genera UNA contraseña
    public function generatePassword($params)
    {
        // Primero cojo los parámetros que me pasan
        $length = $params->length;              // ¿Cuántos caracteres quiero?
        $useNumbers = $params->useNumbers;      // ¿Quiero números?
        $useSymbols = $params->useSymbols;      // ¿Quiero símbolos como !@#?
        $useUppercase = $params->useUppercase;  // ¿Quiero mayúsculas?

        // Ahora voy a construir un string con TODOS los caracteres que puedo usar
        $chars = '';

        // SIEMPRE añado minúsculas (si no, no habría nada)
        $chars = $chars . 'abcdefghijklmnopqrstuvwxyz';

        // Si quiero mayúsculas, las añado también
        if ($useUppercase) {
            $chars = $chars . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        // Si quiero números, los añado
        if ($useNumbers) {
            $chars = $chars . '0123456789';
        }

        // Si quiero símbolos, los añado
        // Estos símbolos los saqué del ejemplo 2 del profesor
        if ($useSymbols) {
            $chars = $chars . '!?~@#-_+<>[]{}';
        }

        // Si por alguna razón no hay caracteres, lanzo un error
        if ($chars === '') {
            throw new Exception('Debe seleccionar al menos un tipo de caracteres');
        }

        // Aquí empieza la magia: generar la contraseña
        // random_int() es de PHP 7 y es criptográficamente seguro
        $password = '';
        $chars_length = strlen($chars) - 1;  // -1 porque los arrays empiezan en 0

        // Repito esto tantas veces como longitud quiera
        for ($i = 0; $i < $length; $i++) {
            // random_int me da un número aleatorio entre 0 y el tamaño del string
            $n = random_int(0, $chars_length);
            // Con ese número, cojo un caracter del string
            $password = $password . $chars[$n];
        }

        // Devuelvo la contraseña generada
        return array(
            'password' => $password,
            'length' => $length
        );
    }

    // Este método genera VARIAS contraseñas de golpe
    // Lo saqué del ejemplo 2: https://www.phpjabbers.com/generate-a-random-password-with-php-php70.html
    public function generateMultiple($params)
    {
        $count = $params->count;    // ¿Cuántas contraseñas quiero?
        $length = $params->length;
        $passwords = array();       // Array vacío para ir guardando las contraseñas

        // Repito el proceso de generar contraseña tantas veces como pida
        for ($i = 0; $i < $count; $i++) {
            $result = $this->generatePassword($params);  // Llamo al método de arriba
            $passwords[] = $result['password'];          // Guardo solo la contraseña en el array
        }

        // Devuelvo todas las contraseñas generadas
        return array(
            'passwords' => $passwords,
            'count' => $count,
            'length' => $length
        );
    }
}
