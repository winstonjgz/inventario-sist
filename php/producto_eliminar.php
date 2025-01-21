<?php

$product_id_del = limpiar_cadena($_GET['product_id_del']);

//Verificar que el producto no sea el administrador y exista
$check_producto = conexion()->query("SELECT id_producto FROM producto WHERE id_producto='$product_id_del' LIMIT 1");
if ($check_producto->rowCount() == 1) {

    //Verificar que el producto exista con registros en productos
    $check_productos = conexion()->query("SELECT * FROM producto WHERE id_producto='$product_id_del' LIMIT 1");

    if ($check_productos->rowCount() == 1) {
       
        $datos = $check_productos->fetch();
        
        $eliminar_producto = conexion()->prepare("DELETE FROM producto WHERE id_producto = :id_producto");
        $eliminar_producto->execute([":id_producto" => $product_id_del]);

        if ($eliminar_producto->rowCount() === 1) {
            if(is_file("./img/productos/".$datos['producto_imagen'])){
                chmod("./img/productos/".$datos['producto_imagen'],0777 );
                unlink("./img/productos/".$datos['producto_imagen']);
            }
            echo '
            <div class="notification is-info is-light">
                <strong>¡Operación exitosa!</strong><br>
                Producto eliminada exitosamente!
            </div>';
        } else {
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No pudimos eliminar el producto, por favor intente nuevamente.
            </div>';
        }

        $eliminar_producto = null;
        $conexion = null;  // Cerrar conexión
    } else {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No podemos eliminar el producto porque tiene productos registrados.
        </div>';
        $conexion = null;  // Cerrar conexión
    }

    $check_productos = null;
} else {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    El producto que intenta eliminar no existe!
    </div>
    ';
}
