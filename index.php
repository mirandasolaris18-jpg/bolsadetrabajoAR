<?php
require_once __DIR__ . '/controladores/BolsaControlador.php';
$controlador = new BolsaControlador();
$accion = $_GET['accion'] ?? 'inicio';
$controlador->procesarAccion($accion);