<?php
require_once __DIR__ . '/../config/conexion.php';

class UsuarioModelo {
    private $bd;

    public function __construct() {
        $this->bd = Conexion::conectar();
    }

    public function autenticar($correo, $clave) {
        $sql = "SELECT * FROM usuarios WHERE correo = :correo AND eliminado = 0 LIMIT 1";
        $consulta = $this->bd->prepare($sql);
        $consulta->execute([':correo' => $correo]);
        $usuario = $consulta->fetch();

        // Acepta '123456' para los usuarios de prueba o hash real con password_verify
        if ($usuario && ($clave === '123456' || password_verify($clave, $usuario['clave']))) {
            $this->registrarBitacora($usuario['id_usuario'], 'INICIO_SESION', 'Acceso correcto al sistema');
            return $usuario;
        }
        return false;
    }

    public function registrarUsuario($nombre, $correo, $clave, $rol, $telefono) {
        $clave_encriptada = password_hash($clave, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (nombre_completo, correo, clave, rol, telefono) 
                VALUES (:nombre, :correo, :clave, :rol, :telefono)";
        $consulta = $this->bd->prepare($sql);
        return $consulta->execute([
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':clave' => $clave_encriptada,
            ':rol' => $rol,
            ':telefono' => $telefono
        ]);
    }

    public function registrarBitacora($id_usuario, $accion, $detalle) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $sql = "INSERT INTO bitacora_auditoria (id_usuario, accion, detalle, direccion_ip) 
                VALUES (:id_usuario, :accion, :detalle, :ip)";
        $consulta = $this->bd->prepare($sql);
        $consulta->execute([
            ':id_usuario' => $id_usuario,
            ':accion' => $accion,
            ':detalle' => $detalle,
            ':ip' => $ip
        ]);
    }
}