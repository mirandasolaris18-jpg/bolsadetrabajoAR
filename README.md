# Bolsa de Trabajo GADOR (PHP + MySQL)

Proyecto desarrollado en PHP nativo con arquitectura MVC y base de datos MySQL, completamente adaptado con variables, tablas y rutas en español.

## Estructura del Proyecto

- `/aplicacion`: Código fuente principal (Configuración, Controladores, Vistas).
- `/database`: Script SQL (`esquema.sql`) para inicializar la base de datos MySQL.
- `/publico`: Directorio público raíz de la aplicación.

## Instalación

1. Importar `database/esquema.sql` en MySQL (phpMyAdmin o MySQL CLI).
2. Configurar credenciales de BD en `aplicacion/Configuracion/BaseDatos.php`.
3. Servir la carpeta `publico/` mediante Apache, Nginx o el servidor embebido de PHP:
   `php -S localhost:8000 -t publico`
