<?php
require_once "../inc/session_start.php";
require_once "main.php";

$id_cat = limpiar_cadena($_POST['id_producto_up']);

//Verificar si existe el producto en la base de datos
$check_producto = conexion()->query('SELECT * FROM producto WHERE id_producto="' . $id_cat . '"');

if ($check_producto->rowCount() <= 0) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    producto no existe!
    </div>
    ';
    exit();
} else {
    $datos = $check_producto->fetch();
}

$check_producto = null;


//Almacenando datos

$producto_codigo = limpiar_cadena($_POST['producto_codigo']);
$producto_nombre = limpiar_cadena($_POST['producto_nombre']);
$producto_precio = limpiar_cadena($_POST['producto_precio']);
$producto_stock = limpiar_cadena($_POST['producto_stock']);
$producto_categoria = limpiar_cadena($_POST['producto_categoria']);

if ($nombre_cat == "" || $ubicacion_cat  == "" ) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No has llenado todos los campos que son obligatorios
    </div>
    ';
    exit();
}


//Verificar integridad de los datos
if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre_cat)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del nombre con el formato requerido!
    </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,50}", $ubicacion_cat)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del apellido con el formato requerido!
    </div>
    ';
    exit();
}


// Verificar producto
if ($nombre_cat != $datos['producto_nombre']) {
    $check_producto = conexion();
    $check_producto = $check_producto->query("SELECT producto_nombre FROM producto WHERE producto_nombre = '$nombre_cat'");
    if ($check_producto->rowCount() > 0) {
        echo '
        <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El producto esta registrado en la base de datos!
        Por favor escriba otro!
        </div>
        ';
        exit();
    }

    $check_producto = null;
}


//Actualizando datos
$actualizar_producto = conexion()->prepare('UPDATE producto SET producto_nombre=:nombre, producto_ubicacion=:ubicacion WHERE id_producto=:id');

$marcadores = [
    ":nombre" => $nombre_cat,
    ":ubicacion" => $ubicacion_cat,
    ":id" => $id_cat,
];




if ($actualizar_producto->execute($marcadores)) {
    echo '
    <div class="notification is-info is-light">
    <strong>¡Actualización exitosa!</strong><br>
    El producto fue actualizado exitosamente!
    </div>
    ';
} else {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No se pudo actualizar el producto!
    Por favor verifique!
    </div>
    ';
}

$actualizar_producto = null;
