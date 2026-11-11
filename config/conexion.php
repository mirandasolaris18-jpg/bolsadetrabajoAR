<?php
require_once __DIR__ . '/env.php';

class Conexion {
    public static function conectar() {
        try {
            $dsn = "mysql:host=" . $_ENV['BD_SERVIDOR'] . ";dbname=" . $_ENV['BD_NOMBRE'] . ";charset=utf8mb4";
            $opciones = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            return new PDO($dsn, $_ENV['BD_USUARIO'], $_ENV['BD_CLAVE'], $opciones);
        } catch (PDOException $error) {
            die("Error de conexión segura a la base de datos.");
        }
    }
}