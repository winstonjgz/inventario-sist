<?php
require_once "../inc/session_start.php";
require_once "main.php";

$id_prod = limpiar_cadena($_POST['id_producto_del']);

//Verificar si existe el producto en la base de datos
$check_producto = conexion()->query('SELECT * FROM producto WHERE id_producto="' . $id_prod . '"');

if ($check_producto->rowCount() == 1) {
    $datos = $check_producto->fetch();
} else {
    echo '
        <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        La imagen del producto no existe!
        </div>
        ';
    exit();
}

$check_producto = null;




//Directorio de imagenes
$img_dir = "../img/productos/";
chmod($img_dir, 0777);

if (is_file($img_dir . $datos['producto_imagen'])) {
    chmod($img_dir . $datos['producto_imagen'], 0777);
    if (!unlink($img_dir . $datos['producto_imagen'])) {
        echo '
        <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        Error al eliminar la imagen del producto!
        </div>
        ';
        exit();
    }
}


//Actualizando datos
$actualizar_producto = conexion()->prepare('UPDATE producto  SET producto_imagen=:prod_img WHERE id_producto=:id');
$marcadores = [
    ':prod_img' => '',
    ':id' => $id_prod,
];




if ($actualizar_producto->execute($marcadores)) {
    echo '
    <div class="notification is-info is-light">
    <strong>¡Actualización exitosa!</strong><br>
    La imagen fue eliminada exitosamente, pulse Aceptar para recargar los cambios!

    <p class="has-text-centered pt-5 pb-5">
    <a href="index.php?vista=product_img&id_producto_up='.$id_prod.'" class="button is-info is-rounded">
    <strong>Aceptar</strong>
    </a>
    </p>
    </div>
    ';
} else {
    echo '
    <div class="notification is-warning is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Problemas al eliminar la imagen del producto!
    Sin embargo se udo eliminar, pulse Aceptar para recargar los cambios!

    <p class="has-text-centered pt-5 pb-5">
    <a href="index.php?vista=product_img&id_producto_up='.$id_prod.'" class="button is-info is-rounded">
    <strong>Aceptar</strong>
    </a>
    </p>

    </div>
    ';
}

$actualizar_producto = null;