<?php
require_once "../inc/session_start.php";
require_once "main.php";

$id_prod = limpiar_cadena($_POST['id_producto_up']);

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

// Comprobar si se selecciono una imagen
if ($_FILES['producto_imagen']['name'] == "" || $_FILES['producto_imagen']['size'] == 0) {

    echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
           No ha seleccionado una imagen valida!
            </div>
            ';
    exit();
}

if (!file_exists($img_dir)) {
    if (!mkdir($img_dir, 0777)) {
        echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Error al crear el directorio!
            </div>
            ';
        exit();
    }
}

chmod($img_dir, 0777);



//Verificar si la imagen es valida
if (mime_content_type($_FILES['producto_imagen']['tmp_name']) != 'image/jpeg' && mime_content_type($_FILES['producto_imagen']['tmp_name']) != 'image/png' && mime_content_type($_FILES['producto_imagen']['tmp_name']) != 'image/jpg') {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    El archivo seleccionado no es una imagen valida!
    </div>
    ';
    exit();
}



//Verificar el tamaño de la imagen
if (($_FILES['producto_imagen']['size'] / 1024) > 3072) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    La imagen seleccionada es muy grande!
    </div>
    ';
    exit();
}

//Extension de la imagen
switch (mime_content_type($_FILES['producto_imagen']['tmp_name'])) {
    case 'image/jpeg':
        $extension = '.jpg';
        break;
    case 'image/png':
        $extension = '.png';
        break;
    case 'image/jpg':
        $extension = '.jpg';
        break;
    default:
        $extension = '';
        break;
}
chmod($img_dir, 0777);

$img_nombre = renombrar_fotos($datos['producto_nombre']);
$foto = $img_nombre . $extension;

//Moviendo la imagen al directorio
if (!move_uploaded_file($_FILES['producto_imagen']['tmp_name'], $img_dir . $foto)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Error al mover la imagen al directorio!
    </div>
    ';
    exit();
}

//Eliminar la imagen anterior
if (is_file($img_dir . $datos['producto_imagen'] && $datos['producto_imagen'] != $foto)) {
    chmod($img_dir . $datos['producto_imagen'], 0777);
    unlink($img_dir . $datos['producto_imagen']);
}



//Actualizando datos
$actualizar_producto = conexion()->prepare('UPDATE producto  SET producto_imagen=:prod_img WHERE id_producto=:id');
$marcadores = [
    ':prod_img' => $foto,
    ':id' => $id_prod,
];




if ($actualizar_producto->execute($marcadores)) {
    echo '
    <div class="notification is-info is-light">
    <strong>¡Actualización exitosa!</strong><br>
    La imagen fue actualizada exitosamente, pulse Aceptar para recargar los cambios!

    <p class="has-text-centered pt-5 pb-5">
    <a href="index.php?vista=product_img&id_producto_up=' . $id_prod . '" class="button is-info is-rounded">
    <strong>Aceptar</strong>
    </a>
    </p>
    </div>
    ';
} else {
    if (is_file($img_dir . $foto)) {
        chmod($img_dir . $datos['producto_imagen'], 0777);
        unlink($img_dir . $foto);
    }

    echo '
    <div class="notification is-warning is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Problemas al actualizar la imagen del producto!
    Por favor intente nuevamente, pulse Aceptar para recargar los cambios!

    <p class="has-text-centered pt-5 pb-5">
    <a href="index.php?vista=product_img&id_producto_up=' . $id_prod . '" class="button is-info is-rounded">
    <strong>Aceptar</strong>
    </a>
    </p>

    </div>
    ';
}

$actualizar_producto = null;
