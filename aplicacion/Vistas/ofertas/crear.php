<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bolsa de Trabajo GADOR - Publicar Oferta</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <header class="nav">
        <a class="brand" href="/">💼 Bolsa de Trabajo <small>G.A.D.O.R.</small></a>
        <nav>
            <a href="/mis-ofertas">Mis ofertas</a>
            <a href="/ofertas/crear">Publicar</a>
            <a href="/logout">Salir</a>
        </nav>
    </header>

    <main class="container">
        <form class="card narrow" method="post" action="/ofertas/guardar">
            <h1>Publicar oferta laboral</h1>
            
            <label>Cargo / Título
                <input name="titulo" required minlength="5" maxlength="150" placeholder="Ej: Técnico de Instalaciones de Red">
            </label>

            <label>Descripción del Puesto
                <textarea name="descripcion" required minlength="20" rows="6" placeholder="Detalle los requisitos y funciones..."></textarea>
            </label>

            <label>Ciudad
                <input name="ciudad" required value="Oruro">
            </label>

            <label>Modalidad
                <select name="modalidad">
                    <option value="presencial">Presencial</option>
                    <option value="remoto">Remoto</option>
                    <option value="mixto">Mixto</option>
                </select>
            </label>

            <label>Salario en Bs (opcional)
                <input name="salario" type="number" min="0" step="0.01" placeholder="Ej: 3500.00">
            </label>

            <button class="btn" type="submit">Enviar para aprobación</button>
        </form>
    </main>

    <footer>G.A.D.O.R. · Gobierno Autónomo Departamental de Oruro</footer>
</body>
</html>
