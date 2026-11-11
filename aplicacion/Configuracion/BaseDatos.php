<?php
namespace Aplicacion\Configuracion;

use PDO;
use PDOException;

class BaseDatos {
    private static ?PDO $instancia = null;

    public static function obtenerConexion(): PDO {
        if (self::$instancia === null) {
            $host = 'localhost';
            $bd = 'bolsa_gador';
            $usuario = 'root';
            $clave = '';
            $charset = 'utf8mb4';

            $dsn = "mysql:host={$host};dbname={$bd};charset={$charset}";
            $opciones = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instancia = new PDO($dsn, $usuario, $clave, $opciones);
            } catch (PDOException $e) {
                die('Error de conexión a la base de datos: ' . $e->getMessage());
            }
        }
        return self::$instancia;
    }
}
