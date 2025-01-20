<?php

$category_id_del = limpiar_cadena($_GET['category_id_del']);

//Verificar que el categoria no sea el administrador y exista
$check_categoria = conexion()->query("SELECT id_categoria FROM categoria WHERE id_categoria='$category_id_del' AND id_categoria!='1'");
if ($check_categoria->rowCount() == 1) {

    //Verificar que el categoria exista con registros en productos
    $check_productos = conexion()->query("SELECT fk_categoria_id FROM producto WHERE fk_categoria_id='$category_id_del' LIMIT 1");
    
    if ($check_productos->rowCount() <= 0) {
        $conexion = conexion();
        $eliminar_categoria = $conexion->prepare("DELETE FROM categoria WHERE id_categoria = :id_categoria");
        $eliminar_categoria->execute([":id_categoria" => $category_id_del]);
    
        if ($eliminar_categoria->rowCount() === 1) {
            echo '
            <div class="notification is-info is-light">
                <strong>¡Operación exitosa!</strong><br>
                ¡Categoría eliminada exitosamente!
            </div>';
        } else {
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No pudimos eliminar la categoría, por favor intente nuevamente.
            </div>';
        }
    
        $eliminar_categoria = null;
        $conexion = null;  // Cerrar conexión
    } else {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No podemos eliminar la categoría porque tiene productos registrados.
        </div>';
        $conexion = null;  // Cerrar conexión
    }
    
    $check_productos = null;
   
} else {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    El categoria que intenta eliminar no existe!
    </div>
    ';
}
