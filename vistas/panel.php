<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Gestión - G.A.D.OR.</title>
    <link rel="stylesheet" href="publico/estilos.css">
</head>
<body>
    <header class="encabezado">
        <div class="contenedor fila-entre">
            <h1>Panel: <?= htmlspecialchars($_SESSION['usuario']['nombre_completo']) ?></h1>
            <div>
                <a href="index.php" class="boton boton-dorado">Ver Convocatorias</a>
                <a href="index.php?accion=salir" class="boton boton-blanco">Cerrar Sesión</a>
            </div>
        </div>
    </header>

    <main class="contenedor">
        <?php if ($_SESSION['usuario']['rol'] === 'empresa'): ?>
            <div class="grilla-dos">
                <section class="tarjeta-oferta">
                    <h2>Publicar Nueva Convocatoria</h2>
                    <form method="POST" action="index.php?accion=publicar_oferta" class="formulario">
                        <label>Título del Cargo:</label>
                        <input type="text" name="titulo_cargo" required>
                        <label>Requisitos y Funciones:</label>
                        <textarea name="descripcion" rows="3" required></textarea>
                        <label>Municipio:</label>
                        <select name="municipio">
                            <option value="Oruro Cercado">Oruro Cercado</option>
                            <option value="Challapata">Challapata</option>
                            <option value="Huanuni">Huanuni</option>
                            <option value="Caracollo">Caracollo</option>
                        </select>
                        <label>Salario Referencial (Bs):</label>
                        <input type="number" step="0.01" name="salario_referencial" required>
                        <label>Modalidad:</label>
                        <select name="modalidad">
                            <option value="Presencial">Presencial</option>
                            <option value="Semipresencial">Semipresencial</option>
                            <option value="Teletrabajo">Teletrabajo</option>
                        </select>
                        <button type="submit" class="boton boton-rojo">Publicar Vacante</button>
                    </form>
                </section>

                <section class="tarjeta-oferta">
                    <h2>Postulantes Recibidos (<?= count($postulaciones) ?>)</h2>
                    <?php foreach ($postulaciones as $post): ?>
                        <div class="item-postulante">
                            <strong><?= htmlspecialchars($post['postulante']) ?></strong> aplicó a <em><?= htmlspecialchars($post['titulo_cargo']) ?></em>
                            <p><?= htmlspecialchars($post['resumen_perfil']) ?></p>
                            <small>Tel: <?= htmlspecialchars($post['telefono']) ?> | <a href="<?= htmlspecialchars($post['enlace_cv']) ?>" target="_blank">Ver CV</a></small>
                        </div>
                    <?php endforeach; ?>
                </section>
            </div>

            <h2>Administración de Mis Ofertas Activas</h2>
            <div class="grilla-ofertas">
                <?php foreach ($ofertas as $oferta): ?>
                    <?php if ($oferta['id_empresa'] == $_SESSION['usuario']['id_usuario']): ?>
                        <div class="tarjeta-oferta">
                            <h3><?= htmlspecialchars($oferta['titulo_cargo']) ?></h3>
                            <p>Salario: Bs. <?= number_format($oferta['salario_referencial'], 2) ?></p>
                            <a href="index.php?accion=eliminar_oferta&id=<?= $oferta['id_oferta'] ?>" class="boton boton-rojo" onclick="return confirm('¿Dar de baja lógica esta convocatoria?')">Dar de Baja</a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="tarjeta-oferta">
                <h2>Perfil Profesional Activo</h2>
                <p>Estás habilitado para postular a cualquier convocatoria vigente del Departamento de Oruro desde la pantalla principal.</p>
                <a href="index.php" class="boton boton-rojo">Ir a Buscar Vacantes</a>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>