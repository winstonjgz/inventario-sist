<?php
require_once "../inc/session_start.php";
require_once "main.php";

$id_cat = limpiar_cadena($_POST['id_categoria_up']);

//Verificar si existe el categoria en la base de datos
$check_categoria = conexion()->query('SELECT * FROM categoria WHERE id_categoria="' . $id_cat . '"');

if ($check_categoria->rowCount() <= 0) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    categoria no existe!
    </div>
    ';
    exit();
} else {
    $datos = $check_categoria->fetch();
}

$check_categoria = null;


//Almacenando datos

$nombre_cat = limpiar_cadena($_POST['categoria_nombre']);
$ubicacion_cat = limpiar_cadena($_POST['categoria_ubicacion']);

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


// Verificar categoria
if ($nombre_cat != $datos['categoria_nombre']) {
    $check_categoria = conexion();
    $check_categoria = $check_categoria->query("SELECT categoria_nombre FROM categoria WHERE categoria_nombre = '$nombre_cat'");
    if ($check_categoria->rowCount() > 0) {
        echo '
        <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El categoria esta registrado en la base de datos!
        Por favor escriba otro!
        </div>
        ';
        exit();
    }

    $check_categoria = null;
}


//Actualizando datos
$actualizar_categoria = conexion()->prepare('UPDATE categoria SET categoria_nombre=:nombre, categoria_ubicacion=:ubicacion WHERE id_categoria=:id');

$marcadores = [
    ":nombre" => $nombre_cat,
    ":ubicacion" => $ubicacion_cat,
    ":id" => $id_cat,
];




if ($actualizar_categoria->execute($marcadores)) {
    echo '
    <div class="notification is-info is-light">
    <strong>¡Actualización exitosa!</strong><br>
    El categoria fue actualizado exitosamente!
    </div>
    ';
} else {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No se pudo actualizar el categoria!
    Por favor verifique!
    </div>
    ';
}

$actualizar_categoria = null;
