<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - Bolsa de Trabajo G.A.D.OR.</title>
    <link rel="stylesheet" href="publico/estilos.css">
</head>
<body>
    <header class="encabezado">
        <div class="contenedor fila-entre">
    <h1>Acceso al Sistema Departamental</h1>
    <a href="index.php" class="boton boton-blanco">Volver al Inicio</a>
        </div>
    </header>
    <main class="contenedor grilla-dos">
        <section class="tarjeta-oferta">
            <h2>Iniciar Sesión</h2>
            <p><small>Demo Empresa: rrhh@oruro.gob.bo | Demo Postulante: juan@correo.bo (Clave: 123456)</small></p>
            <?php if (!empty($mensaje_error)): ?>
                <div class="alerta-error"><?= $mensaje_error ?></div>
            <?php endif; ?>
            <form method="POST" action="index.php?accion=ingresar" class="formulario">
     <label>Correo Electrónico:</label> <input type="email" name="correo" required> <label>Contraseña:</label>
    <input type="password" name="clave" required>  <button type="submit" class="boton boton-rojo">Ingresar</button>
            </form>
        </section>

        <section class="tarjeta-oferta">
            <h2>Registro Nuevo (Profesional o Empresa)</h2>
            <form method="POST" action="index.php?accion=registrar_usuario" class="formulario">
                <label>Nombre Completo o Institución:</label>
                <input type="text" name="nombre_completo" required>
                <label>Correo Electrónico:</label>
                <input type="email" name="correo" required>
                <label>Contraseña:</label>
                <input type="password" name="clave" required>
                <label>Teléfono / Celular:</label>
                <input type="text" name="telefono" required>
                <label>Tipo de Cuenta:</label>
                <select name="rol">
                    <option value="postulante">Profesional / Técnico Postulante</option>
                    <option value="empresa">Empresa / Unidad Pública</option>
                </select>
                <button type="submit" class="boton boton-dorado">Crear Cuenta</button>
            </form>
        </section>
    </main>
</body>
</html>