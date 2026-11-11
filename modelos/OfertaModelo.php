<?php
require_once __DIR__ . '/../config/conexion.php';

class OfertaModelo {
    private $bd;

    public function __construct() {
        $this->bd = Conexion::conectar();
    }

    public function listarOfertas($busqueda = '', $municipio = '') {
        $sql = "SELECT o.*, u.nombre_completo AS nombre_empresa 
                FROM ofertas_laborales o
                INNER JOIN usuarios u ON o.id_empresa = u.id_usuario
                WHERE o.eliminado = 0 AND o.estado_oferta = 'Vigente'";
        $parametros = [];

        if (!empty($busqueda)) {
            $sql .= " AND (o.titulo_cargo LIKE :busqueda OR o.descripcion LIKE :busqueda)";
            $parametros[':busqueda'] = "%$busqueda%";
        }
        if (!empty($municipio)) {
            $sql .= " AND o.municipio = :municipio";            $parametros[':municipio'] = $municipio;
        }

        $sql .= " ORDER BY o.fecha_publicacion DESC"; $consulta = $this->bd->prepare($sql);
        $consulta->execute($parametros);        return $consulta->fetchAll();
    }

    public function crearOferta($id_empresa, $titulo, $descripcion, $municipio, $salario, $modalidad) {
        $sql = "INSERT INTO ofertas_laborales (id_empresa, titulo_cargo, descripcion, municipio, salario_referencial, modalidad)
                VALUES (:id_empresa, :titulo, :descripcion, :municipio, :salario, :modalidad)";
        $consulta = $this->bd->prepare($sql);
        return $consulta->execute([
            ':id_empresa' => $id_empresa,
            ':titulo' => $titulo,
            ':descripcion' => $descripcion,
            ':municipio' => $municipio,
            ':salario' => $salario,
            ':modalidad' => $modalidad
        ]);
    }

    public function eliminarOfertaLogico($id_oferta, $id_empresa) {
        $sql = "UPDATE ofertas_laborales SET eliminado = 1 WHERE id_oferta = :id_oferta AND id_empresa = :id_empresa";
        $consulta = $this->bd->prepare($sql);
        return $consulta->execute([':id_oferta' => $id_oferta, ':id_empresa' => $id_empresa]);
    }

    public function postularOferta($id_oferta, $id_postulante, $resumen, $enlace_cv) {
        $sql = "INSERT INTO postulaciones (id_oferta, id_postulante, resumen_perfil, enlace_cv)
                VALUES (:id_oferta, :id_postulante, :resumen, :enlace_cv)";
        $consulta = $this->bd->prepare($sql);
        return $consulta->execute([
            ':id_oferta' => $id_oferta,
            ':id_postulante' => $id_postulante,
            ':resumen' => $resumen,
            ':enlace_cv' => $enlace_cv
        ]);
    }

    public function listarPostulacionesRecibidas($id_empresa) {
        $sql = "SELECT p.*, o.titulo_cargo, u.nombre_completo AS postulante, u.telefono, u.correo
                FROM postulaciones p
                INNER JOIN ofertas_laborales o ON p.id_oferta = o.id_oferta
                INNER JOIN usuarios u ON p.id_postulante = u.id_usuario
                WHERE o.id_empresa = :id_empresa AND o.eliminado = 0
                ORDER BY p.fecha_postulacion DESC";
        $consulta = $this->bd->prepare($sql);
        $consulta->execute([':id_empresa' => $id_empresa]);
        return $consulta->fetchAll();
    }
}