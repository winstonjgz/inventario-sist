<?php
require_once "main.php";

//Almacenando datos
$categoria_nombre = limpiar_cadena($_POST['categoria_nombre']);
$categoria_ubicacion = limpiar_cadena($_POST['categoria_ubicacion']);



//Verificar campos obligatorios
if($categoria_nombre == "" || $categoria_ubicacion  == ""  ){
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No has llenado todos los campos que son obligatorios
    </div>
    ';
    exit();
}

//Verificar integridad de los datos
if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$categoria_nombre)){
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del nombre con el formato requerido!
    </div>
    ';
    exit();
}

if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,50}",$categoria_ubicacion)){
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error en la ubicación con el formato requerido!
    </div>
    ';
    exit();
}


// Verificar categoria

        $check_categoria = conexion();
        $check_categoria = $check_categoria->query("SELECT categoria_nombre FROM categoria WHERE categoria_nombre = '$categoria_nombre'");
        if($check_categoria->rowCount()>0){
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
    



//Guardando datos

$guardar_categoria = conexion();


//Por razones de seguridad el anterior se cambia al siguiente colocando filtro de seguridad:
$guardar_categoria = $guardar_categoria->prepare("INSERT INTO categoria(categoria_nombre, categoria_ubicacion) VALUES(:nombre, :categoria)");
$marcadores = [
    ":nombre"=> $categoria_nombre, 
    ":categoria"=> $categoria_ubicacion, 
    ];
$guardar_categoria->execute($marcadores);

if($guardar_categoria->rowCount()==1){
    echo '
    <div class="notification is-info is-light">
    <strong>¡Registro exitoso!</strong><br>
    La categoria fue registrada exitosamente!
    </div>
    ';
}else{
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No se pudo registrar la categoria!
    Por favor verifique!
    </div>
    ';
}

$guardar_categoria = null;