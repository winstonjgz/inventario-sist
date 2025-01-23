<?php
require_once "../inc/session_start.php";
require_once "main.php";

$id_prod = limpiar_cadena($_POST['id_producto_up']);

//Verificar si existe el producto en la base de datos
$check_producto = conexion()->query('SELECT * FROM producto WHERE id_producto="' . $id_prod . '"');

if ($check_producto->rowCount() <= 0) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    El producto no existe!
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

if ($producto_codigo == '' || $producto_nombre == '' || $producto_precio == '' || $producto_stock == '' || $producto_categoria == '') {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No has llenado todos los campos que son obligatorios
    </div>
    ';
    exit();
}

//Verificar integridad de los datos
if (verificar_datos("[a-zA-Z0-9 ]{1,70}", $producto_codigo)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error en la ubicación con el formato requerido!
    </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $producto_nombre)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del nombre con el formato requerido!
    </div>
    ';
    exit();
}

if (verificar_datos("[0-9.]{1,20}", $producto_precio)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del precio con el formato requerido!
    </div>
    ';
    exit();
}

if (verificar_datos("[0-9.]{1,20}", $producto_stock)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del stock con el formato requerido!
    </div>
    ';
    exit();
}

// Verificar codigo
if ($datos['producto_id'] != $producto_codigo) {
    $check_codigo = conexion();
    $check_codigo = $check_codigo->query("SELECT producto_id FROM producto WHERE producto_id = '$producto_codigo'");
    if ($check_codigo->rowCount() > 0) {
        echo '
        <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El codigo esta registrado en la base de datos!
        Por favor escriba otro!
        </div>
        ';
        exit();
    }
    $check_codigo = null;
}



// Verificar nombre producto
if ($datos['producto_nombre'] != $producto_nombre) {
    $check_producto = conexion();
    $check_producto = $check_producto->query("SELECT producto_nombre FROM producto WHERE producto_nombre = '$producto_nombre'");
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

// Verificar categoria
if ($datos['fk_categoria_id'] != $producto_categoria) {
$check_categoria = conexion();
$check_categoria = $check_categoria->query("SELECT id_categoria FROM categoria WHERE id_categoria = '$producto_categoria'");
if ($check_categoria->rowCount() <= 0) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    La categoria ID no esta registrado en la base de datos!
    Por favor escriba otro!
    </div>
    ';
    exit();
}
$check_categoria = null;
}


//Actualizando datos
$actualizar_producto = conexion()->prepare('UPDATE producto  SET producto_id=:prod_cod, producto_nombre=:prod_nom, producto_precio=:prod_prec, producto_stock=:prod_sto, fk_categoria_id=:prod_cat WHERE id_producto=:id');
$marcadores = [
    ':prod_cod' => $producto_codigo,
    ':prod_nom' => $producto_nombre,
    ':prod_prec' => $producto_precio,
    ':prod_sto' => $producto_stock,
    ':prod_cat' => $producto_categoria,
    ':id' => $id_prod,
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
