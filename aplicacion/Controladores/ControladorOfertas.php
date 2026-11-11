<?php
namespace Aplicacion\Controladores;

use Aplicacion\Configuracion\BaseDatos;
use PDO;

class ControladorOfertas {
    public function listar() {
        $conexion = BaseDatos::obtenerConexion();
        $consulta = $conexion->query("SELECT * FROM ofertas_laborales WHERE estado = 'aprobado' ORDER BY creado_en DESC");
        $ofertas = $consulta->fetchAll();

        require __DIR__ . '/../Vistas/ofertas/index.php';
    }

    public function crear() {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit;
        }
        require __DIR__ . '/../Vistas/ofertas/crear.php';
    }

    public function guardar() {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit;
        }

        $titulo = trim($_POST['titulo'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $ciudad = trim($_POST['ciudad'] ?? 'Oruro');
        $modalidad = $_POST['modalidad'] ?? 'presencial';
        $salario = !empty($_POST['salario']) ? $_POST['salario'] : null;

        $conexion = BaseDatos::obtenerConexion();
        $consulta = $conexion->prepare("INSERT INTO ofertas_laborales (usuario_id, titulo, descripcion, ciudad, modalidad, salario) VALUES (:usuario_id, :titulo, :descripcion, :ciudad, :modalidad, :salario)");
        $consulta->execute([
            'usuario_id' => $_SESSION['usuario_id'],
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'ciudad' => $ciudad,
            'modalidad' => $modalidad,
            'salario' => $salario
        ]);

        header('Location: /mis-ofertas');
        exit;
    }
}
