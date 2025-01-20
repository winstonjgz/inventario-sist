<?php
require_once "../inc/session_start.php";
require_once "main.php";

//Almacenando datos
$producto_codigo = limpiar_cadena($_POST['producto_codigo']);
$producto_nombre = limpiar_cadena($_POST['producto_nombre']);
$producto_precio = limpiar_cadena($_POST['producto_precio']);
$producto_stock = limpiar_cadena($_POST['producto_stock']);
$producto_categoria = limpiar_cadena($_POST['producto_categoria']);

//Verificar campos obligatorios
if($producto_codigo== '' || $producto_nombre== '' || $producto_precio== '' || $producto_stock== '' || $producto_categoria== '' ){
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No has llenado todos los campos que son obligatorios
    </div>
    ';
    exit();
}

//Verificar integridad de los datos
if(verificar_datos("[a-zA-Z0-9 ]{1,70}",$producto_codigo)){
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error en la ubicación con el formato requerido!
    </div>
    ';
    exit();
}

if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$producto_nombre)){
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del nombre con el formato requerido!
    </div>
    ';
    exit();
}

if(verificar_datos("[0-9.]{1,20}",$producto_precio)){
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del nombre con el formato requerido!
    </div>
    ';
    exit();
}

if(verificar_datos("[0-9.]{1,20}",$producto_stock)){
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del nombre con el formato requerido!
    </div>
    ';
    exit();
}

// Verificar codigo
$check_codigo = conexion();
$check_codigo = $check_codigo->query("SELECT producto_id FROM producto WHERE producto_id = '$producto_codigo'");
if($check_codigo->rowCount()>0){
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

// Verificar producto
$check_producto = conexion();
$check_producto = $check_producto->query("SELECT producto_nombre FROM producto WHERE producto_nombre = '$producto_nombre'");
if($check_producto->rowCount()>0){
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

// Verificar categoria
$check_categoria = conexion();
$check_categoria = $check_categoria->query("SELECT id_categoria FROM categoria WHERE id_categoria = '$producto_categoria'");
if($check_categoria->rowCount()<=0){
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

//Directorio de imagenes
$img_dir = "../img/productos/";

// Comprobar si se selecciono una imagen
if($_FILES['producto_imagen']['name'] != "" && $_FILES['producto_imagen']['size'] > 0){
    //Verificando directorio si existe
    if(!file_exists($img_dir)){
        if(!mkdir($img_dir, 0777)){
            echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Error al crear el directorio!
            </div>
            ';
            exit();
        }
    }

    //Verificar si la imagen es valida
    if(mime_content_type($_FILES['producto_imagen']['tmp_name']) != 'image/jpeg' && mime_content_type($_FILES['producto_imagen']['tmp_name']) != 'image/png' && mime_content_type($_FILES['producto_imagen']['tmp_name']) != 'image/jpg'){
        echo '
        <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El archivo seleccionado no es una imagen valida!
        </div>
        ';
        exit();
    }

    //Verificar el tamaño de la imagen
    if(($_FILES['producto_imagen']['size']/1024) > 3072){
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

    $img_nombre = renombrar_fotos($producto_nombre);
    $foto = $img_nombre.$extension;

    //Moviendo la imagen al directorio
    if(!move_uploaded_file($_FILES['producto_imagen']['tmp_name'], $img_dir.$foto)){
        echo '
        <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        Error al mover la imagen al directorio!
        </div>
        ';
        exit();
    }
} else {
    $foto = '';
}

//Guardando datos
$guardar_producto = conexion();
$guardar_producto = $guardar_producto->prepare("INSERT INTO producto(producto_id, producto_nombre, producto_precio, producto_stock, fk_categoria_id, producto_imagen, fk_usuario_id) VALUES(:codigo, :nombre, :precio, :stock, :categoria, :imagen, :usuario)");
$marcadores = [
    ":codigo" => $producto_codigo,
    ":nombre" => $producto_nombre,
    ":precio" => $producto_precio,
    ":stock" => $producto_stock,
    ":categoria" => $producto_categoria,
    ":imagen" => $foto,
    ":usuario" => $_SESSION['id']
];

$guardar_producto->execute($marcadores);

if($guardar_producto->rowCount() == 1){
    echo '
    <div class="notification is-info is-light">
    <strong>¡Registro exitoso!</strong><br>
    La producto fue registrada exitosamente!
    </div>
    ';
} else {
    if(is_file($img_dir.$foto)){
        chmod($img_dir.$foto, 0777);
        unlink($img_dir.$foto);
    }

    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No se pudo registrar la producto!
    Por favor verifique!
    </div>
    ';
}

$guardar_producto = null;
?>