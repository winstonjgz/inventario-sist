# Sistema de Inventario PHP

Este es un sistema de inventario desarrollado en PHP. Permite gestionar usuarios, productos y categorías, así como realizar búsquedas y actualizaciones en la base de datos.

## Estructura del Proyecto

├── .gitignore  
├── css/  
│   ├── bulma.min.css  
│   ├── estilos_login.css  
│   ├── estilos.css  
├── env.php  
├── img/  
├── productos/  
├── inc/  
│   ├── alerta.php  
│   ├── btn_back.php  
│   ├── head_login.php  
│   ├── head.php  
│   ├── navbar.php  
│   ├── script.php  
│   ├── session_start.php  
├── index.php  
├── js/  
│   ├── ajax.js  
├── php/  
│   ├── buscador.php  
│   ├── categoria_editar.php  
│   ├── categoria_eliminar.php  
│   ├── categoria_guardar.php  
│   ├── categoria_listar.php  
│   ├── iniciar_sesion.php  
│   ├── inicio.php  
│   ├── main.php  
│   ├── producto_editar_img.php  
│   ├── producto_editar.php  
│   ├── producto_eliminar_img.php  
│   ├── producto_eliminar.php  
│   ├── usuario_editar.php  
│   ├── usuario_guardar.php  
├── README.md  
├── view/  
│   ├── 404.php  
│   ├── category_new.php  
│   ├── category_update.php  
│   ├── home.php  
│   ├── product_new.php  
│   ├── user_new.php  
│   ├── user_update.php  

## Requisitos

- PHP 7.4 o superior
- Servidor web (Apache, Nginx, etc.)
- Base de datos MySQL

## Instalación

1. Clona el repositorio en tu servidor local:
    ```sh
    git clone https://github.com/winstonjgz/inventario-sist.git
    ```

2. Configura la base de datos y actualiza el archivo [env.php] con tus credenciales de base de datos.

3. Asegúrate de que los directorios [productos] y `vendor/` tengan los permisos adecuados.

4. Importa la base de datos desde el archivo `database.sql` (si está disponible).

## Uso

- Accede a la página principal del sistema a través de tu navegador web.
- Inicia sesión con tus credenciales de administrador.
- Utiliza las diferentes secciones del sistema para gestionar usuarios, productos y categorías.

## Archivos Principales

- [index.php]: Página principal del sistema.
- [main.php]: Contiene funciones comunes utilizadas en el sistema.
- [usuario_guardar.php]: Script para guardar nuevos usuarios.
- [usuario_editar.php]: Script para editar usuarios existentes.
- [user_new.php]: Vista para crear un nuevo usuario.
- [user_update.php]: Vista para actualizar un usuario existente.

## Contribuciones

Las contribuciones son bienvenidas. Por favor, contactame por las vias respectivas.

## Licencia

Este proyecto es adaptado del curso de Carlor Alfaro por Youtube.