<?php
// Enrutador básico

require_once __DIR__ . '/../aplicacion/Configuracion/BaseDatos.php';
require_once __DIR__ . '/../aplicacion/Controladores/ControladorOfertas.php';
require_once __DIR__ . '/../aplicacion/Controladores/ControladorAutenticacion.php';

use Aplicacion\Controladores\ControladorOfertas;
use Aplicacion\Controladores\ControladorAutenticacion;

$ruta = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$metodo = $_SERVER['REQUEST_METHOD'];

if ($ruta === '/' && $metodo === 'GET') {
    (new ControladorOfertas())->listar();
} elseif ($ruta === '/ofertas/crear' && $metodo === 'GET') {
    (new ControladorOfertas())->crear();
} elseif ($ruta === '/ofertas/guardar' && $metodo === 'POST') {
    (new ControladorOfertas())->guardar();
} elseif ($ruta === '/login' && $metodo === 'GET') {
    (new ControladorAutenticacion())->mostrarLogin();
} elseif ($ruta === '/login' && $metodo === 'POST') {
    (new ControladorAutenticacion())->procesarLogin();
} elseif ($ruta === '/logout') {
    (new ControladorAutenticacion())->cerrarSesion();
} else {
    http_response_code(404);
    echo "Página no encontrada";
}
