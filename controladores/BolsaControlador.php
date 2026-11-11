<?php
session_start();
require_once __DIR__ . '/../modelos/UsuarioModelo.php';
require_once __DIR__ . '/../modelos/OfertaModelo.php';

class BolsaControlador {
    private $usuarioModelo;
    private $ofertaModelo;

    public function __construct() {
        $this->usuarioModelo = new UsuarioModelo();
        $this->ofertaModelo = new OfertaModelo();
    }

    public function procesarAccion($accion) {
        switch ($accion) {
case 'ingresar':
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 $usuario = $this->usuarioModelo->autenticar($_POST['correo'], $_POST['clave']);
if ($usuario) {
 $_SESSION['usuario'] = $usuario;
                header("Location: index.php?vista=panel");
                exit;
                    }
                    $mensaje_error = "Credenciales incorrectas.";
                }
                require __DIR__ . '/../vistas/login.php';
                break;

case 'registrar_usuario':
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$this->usuarioModelo->registrarUsuario(
htmlspecialchars($_POST['nombre_completo']),
htmlspecialchars($_POST['correo']),
$_POST['clave'],
$_POST['rol'],
htmlspecialchars($_POST['telefono'])
);
header("Location: index.php?accion=ingresar&registrado=1");
exit;
}
break;

 case 'publicar_oferta':
 if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'empresa') {
 $this->ofertaModelo->crearOferta(
 $_SESSION['usuario']['id_usuario'],
 htmlspecialchars($_POST['titulo_cargo']),
 htmlspecialchars($_POST['descripcion']),
 htmlspecialchars($_POST['municipio']),
 floatval($_POST['salario_referencial']),
 $_POST['modalidad']
 );
 $this->usuarioModelo->registrarBitacora($_SESSION['usuario']['id_usuario'], 'NUEVA_OFERTA', $_POST['titulo_cargo']);
 }
  header("Location: index.php?vista=panel");
 exit;

case 'eliminar_oferta':
 if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'empresa') {
 $this->ofertaModelo->eliminarOfertaLogico(intval($_GET['id']), $_SESSION['usuario']['id_usuario']);
 $this->usuarioModelo->registrarBitacora($_SESSION['usuario']['id_usuario'], 'BAJA_LOGICA_OFERTA', 'ID: ' . $_GET['id']);
  }
  header("Location: index.php?vista=panel");
  exit;

 case 'postular':
 if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'postulante') {
 $this->ofertaModelo->postularOferta(
   intval($_POST['id_oferta']),
 $_SESSION['usuario']['id_usuario'],
  htmlspecialchars($_POST['resumen_perfil']),
 htmlspecialchars($_POST['enlace_cv'])
 );
  $this->usuarioModelo->registrarBitacora($_SESSION['usuario']['id_usuario'], 'POSTULACION', 'Oferta ID: ' . $_POST['id_oferta']);
  header("Location: index.php?postulado=exito");
 exit;
 }
 break;

 case 'salir':
 session_destroy();
header("Location: index.php");
exit;

 default:
 $vista = $_GET['vista'] ?? 'inicio';
 $busqueda = $_GET['busqueda'] ?? '';
  $municipio = $_GET['municipio'] ?? '';
  $ofertas = $this->ofertaModelo->listarOfertas($busqueda, $municipio);

  if ($vista === 'panel' && isset($_SESSION['usuario'])) {
 $postulaciones = [];
    if ($_SESSION['usuario']['rol'] === 'empresa') {
   $postulaciones = $this->ofertaModelo->listarPostulacionesRecibidas($_SESSION['usuario']['id_usuario']);
  }
   require __DIR__ . '/../vistas/panel.php';
    } else {
  require __DIR__ . '/../vistas/inicio.php';
 }
                break;
        }
    }
}