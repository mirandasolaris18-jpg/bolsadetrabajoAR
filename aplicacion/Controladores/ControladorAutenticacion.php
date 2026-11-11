<?php
namespace Aplicacion\Controladores;

use Aplicacion\Configuracion\BaseDatos;
use PDO;

class ControladorAutenticacion {
    public function mostrarLogin() {
        require __DIR__ . '/../Vistas/autenticacion/login.php';
    }

    public function procesarLogin() {
        session_start();
        $correo = trim($_POST['correo'] ?? '');
        $clave = $_POST['clave'] ?? '';

        $conexion = BaseDatos::obtenerConexion();
        $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE correo = :correo LIMIT 1");
        $consulta->execute(['correo' => $correo]);
        $usuario = $consulta->fetch();

        if ($usuario && password_verify($clave, $usuario['clave'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_rol'] = $usuario['rol'];
            header('Location: /');
            exit;
        }

        $error = "Credenciales incorrectas";
        require __DIR__ . '/../Vistas/autenticacion/login.php';
    }

    public function cerrarSesion() {
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }
}
