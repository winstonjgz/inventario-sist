<?php
require_once "main.php";

//Almacenando datos
$nombre = limpiar_cadena($_POST['usuario_nombre']);
$apellido = limpiar_cadena($_POST['usuario_apellido']);

$usuario = limpiar_cadena($_POST['usuario_usuario']);
$email = limpiar_cadena($_POST['usuario_email']);

$password1 = limpiar_cadena($_POST['usuario_password_1']);
$password2 = limpiar_cadena($_POST['usuario_password_2']);

//Verificar campos obligatorios
if($nombre == "" || $apellido  == "" || $usuario  == "" || $email  == "" || $password1  == "" || $password2  == "" ){
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No has llenado todos los campos que son obligatorios
    </div>
    ';
    exit();
}

//Verificar integridad de los datos
if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del nombre con el formato requerido!
    </div>
    ';
    exit();
}

if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del apellido con el formato requerido!
    </div>
    ';
    exit();
}

if(verificar_datos("[a-zA-Z]{10,40}", $usuario)){
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del usuario con el formato requerido!
    </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-Z0-9$@.#]{12,100}", $password1) || verificar_datos("[a-zA-Z0-9$@.#]{12,100}", $password2)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrió un error inesperado!</strong><br>
    Existe un error con los password con el formato requerido.
    </div>
    ';
    exit();
}


// Verificando el email
if($email != ""){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $check_email = conexion();
        $check_email = $check_email->query("SELECT usuario_email FROM usuario WHERE usuario_email = '$email'");
        if($check_email->rowCount()>0){
            echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El email esta registrado en la base de datos!
            Por favor escriba otro!
            </div>
            ';
            exit();
        }
        $check_email = null;
    }else{
        echo '
        <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        Existe un error con el formato requerido del correo!
        </div>
        ';
        exit();
    }
}


// Verificar usuario

        $check_usuario = conexion();
        $check_usuario = $check_usuario->query("SELECT usuario_usuario FROM usuario WHERE usuario_usuario = '$usuario'");
        if($check_usuario->rowCount()>0){
            echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El usuario esta registrado en la base de datos!
            Por favor escriba otro!
            </div>
            ';
            exit();
        }
        $check_usuario = null;
    

//Verificacion de contraseñas

if($password1 != $password2){
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Los password no son iguales!
    Por favor verifique!
    </div>
    ';
    exit();
}else{
    $password = password_hash($password1, PASSWORD_BCRYPT,["cost"=>10]);
}

//Guardando datos

$guardar_usuario = conexion();
/*$guardar_usuario = $guardar_usuario->query("INSERT INTO usuario(usuario_nombre, usuario_apellido, usuario_usuario, usuario_password, usuario_email) VALUES('$nombre', '$apellido', '$usuario', '$password', '$email')");*/

//Por razones de seguridad el anterior se cambia al siguiente colocando filtro de seguridad:
$guardar_usuario = $guardar_usuario->prepare("INSERT INTO usuario(usuario_nombre, usuario_apellido, usuario_usuario, usuario_password, usuario_email) VALUES(:nombre, :apellido, :usuario, :password, :email)");
$marcadores = [
    ":nombre"=> $nombre, 
    ":apellido"=> $apellido, 
    ":usuario"=> $usuario, 
    ":password"=> $password, 
    ":email"=> $email
];
$guardar_usuario->execute($marcadores);

if($guardar_usuario->rowCount()==1){
    echo '
    <div class="notification is-info is-light">
    <strong>¡Registro exitoso!</strong><br>
    El usuario fue registrado exitosamente!
    </div>
    ';
}else{
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No se pudo registrar el usuario!
    Por favor verifique!
    </div>
    ';
}

$guardar_usuario = null;