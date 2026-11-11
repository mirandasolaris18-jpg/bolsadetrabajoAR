<?php
function cargarEntorno($ruta_archivo) {
 if (!file_exists($ruta_archivo)) {
 die("Error crítico: Falta el archivo de configuración .env");
    }
$lineas = file($ruta_archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lineas as $linea) {
 if (strpos(trim($linea), '#') === 0) continue;   list($nombre, $valor) = explode('=', $linea, 2);
    $_ENV[trim($nombre)] = trim($valor, ' "');
    }
}
cargarEntorno(__DIR__ . '/../.env');