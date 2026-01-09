<?php

/**
 * Clase generadora de contraseñas
 * Basado en: https://www.phpjabbers.com/generate-a-random-password-with-php-php70.html
 * Usa random_int() de PHP 7 para generar números aleatorios criptográficamente seguros
 */
class PasswordGenerator
{
    // Método público para generar una contraseña
    public function generatePassword($params)
    {
        // Obtener parámetros
        $length = $params->length;
        $useNumbers = $params->useNumbers;
        $useSymbols = $params->useSymbols;
        $useUppercase = $params->useUppercase;

        // Construir el conjunto de caracteres disponibles
        $chars = '';

        // Siempre incluir minúsculas
        $chars = $chars . 'abcdefghijklmnopqrstuvwxyz';

        // Añadir mayúsculas si está activado
        if ($useUppercase) {
            $chars = $chars . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        // Añadir números si está activado
        if ($useNumbers) {
            $chars = $chars . '0123456789';
        }

        // Añadir símbolos si está activado
        if ($useSymbols) {
            $chars = $chars . '!?~@#-_+<>[]{}';
        }

        // Verificar que hay caracteres disponibles
        if ($chars === '') {
            throw new Exception('Debe seleccionar al menos un tipo de caracteres');
        }

        // Generar la contraseña usando random_int()
        $password = '';
        $chars_length = strlen($chars) - 1;

        for ($i = 0; $i < $length; $i++) {
            $n = random_int(0, $chars_length);
            $password = $password . $chars[$n];
        }

        // Devolver resultado
        return array(
            'password' => $password,
            'length' => $length
        );
    }

    // Método público para generar múltiples contraseñas
    public function generateMultiple($params)
    {
        $count = $params->count;
        $length = $params->length;
        $passwords = array();

        for ($i = 0; $i < $count; $i++) {
            $result = $this->generatePassword($params);
            $passwords[] = $result['password'];
        }

        return array(
            'passwords' => $passwords,
            'count' => $count,
            'length' => $length
        );
    }
}
