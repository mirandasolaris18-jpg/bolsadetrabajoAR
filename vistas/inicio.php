<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolsa de Trabajo Departamental - G.A.D.OR.</title>
    <link rel="stylesheet" href="publico/estilos.css">
    <link rel="manifest" href="publico/manifest.json">
    <meta name="theme-color" content="#8B0000">
</head>
<body>
    <header class="encabezado">
        <div class="contenedor fila-entre">
            <div>
                <h1>G.A.D.OR. | Bolsa de Trabajo Digital</h1>
                <p>Gobierno Autónomo Departamental de Oruro</p>
            </div>
            <nav>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <a href="index.php?vista=panel" class="boton boton-dorado">Mi Panel (<?= htmlspecialchars($_SESSION['usuario']['nombre_completo']) ?>)</a>
                    <a href="index.php?accion=salir" class="boton boton-blanco">Salir</a>
                <?php else: ?>
                    <a href="index.php?accion=ingresar" class="boton boton-dorado">Iniciar Sesión / Registro</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="contenedor">
        <?php if (isset($_GET['postulado'])): ?>
            <div class="alerta-exito">¡Tu postulación fue enviada y registrada en bitácora correctamente!</div>
        <?php endif; ?>

        <section class="buscador">
            <form method="GET" action="index.php" class="fila-busqueda">
                <input type="text" name="busqueda" placeholder="Buscar cargo o profesión (ej. Sistemas, Redes)..." value="<?= htmlspecialchars($_GET['busqueda'] ?? '') ?>">
                <select name="municipio">
                    <option value="">Todos los municipios de Oruro</option>
                    <option value="Oruro Cercado">Oruro Cercado</option>
                    <option value="Challapata">Challapata</option>
                    <option value="Huanuni">Huanuni</option>
                    <option value="Caracollo">Caracollo</option>
                </select>
                <button type="submit" class="boton boton-rojo">Filtrar Vacantes</button>
            </form>
        </section>

        <h2>Convocatorias Vigentes en el Departamento</h2>
        <div class="grilla-ofertas">
            <?php foreach ($ofertas as $oferta): ?>
                <article class="tarjeta-oferta">
                    <span class="etiqueta"><?= htmlspecialchars($oferta['modalidad']) ?> | <?= htmlspecialchars($oferta['municipio']) ?></span>
                    <h3><?= htmlspecialchars($oferta['titulo_cargo']) ?></h3>
                    <p class="empresa"><strong>Institución/Empresa:</strong> <?= htmlspecialchars($oferta['nombre_empresa']) ?></p>
                    <p><?= htmlspecialchars($oferta['descripcion']) ?></p>
                    <p class="salario">Haber Básico: Bs. <?= number_format($oferta['salario_referencial'], 2) ?></p>

                    <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] === 'postulante'): ?>
                        <form method="POST" action="index.php?accion=postular" class="form-postular">
                            <input type="hidden" name="id_oferta" value="<?= $oferta['id_oferta'] ?>">
                            <input type="text" name="resumen_perfil" placeholder="Breve resumen de tu título y experiencia..." required>
                            <input type="url" name="enlace_cv" placeholder="Enlace a tu CV en Drive/GitHub (https://...)" required>
                            <button type="submit" class="boton boton-rojo">Postular Ahora</button>
                        </form>
                    <?php elseif (!isset($_SESSION['usuario'])): ?>
                        <a href="index.php?accion=ingresar" class="enlace-login">Inicia sesión como profesional para postular</a>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('publico/sw.js');
        }
    </script>
</body>
</html>