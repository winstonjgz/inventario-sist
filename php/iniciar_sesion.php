<?php
require_once "main.php";

//Almacenando datos
$usuario = limpiar_cadena($_POST['login_usuario']);
$password = limpiar_cadena($_POST['password_usuario']);

if($usuario  == "" || $password  == "" ){
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No has llenado todos los campos que son obligatorios
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


if (verificar_datos("[a-zA-Z0-9$@.#]{12,100}", $password)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrió un error inesperado!</strong><br>
    Existe un error con el password y el formato requerido.
    </div>
    ';
    exit();
}

$check_user = conexion();
$check_user = $check_user->query("SELECT * FROM usuario WHERE usuario_usuario = '$usuario' ");

if($check_user->rowCount()==1){
    $check_user = $check_user -> fetch();

    if($check_user['usuario_usuario']== $usuario && password_verify($password, $check_user['usuario_password'])){
        $_SESSION['id'] = $check_user['id_usuario'];
        $_SESSION['nombre'] = $check_user['usuario_nombre'];
        $_SESSION['apellido'] = $check_user['usuario_apellido'];
        $_SESSION['usuario'] = $check_user['usuario_usuario'];

        if(headers_sent()){
            echo "<script> window.location.href='index.php?vista=home'</script>";
        }else{
            header("Location: index.php?vista=home");
        }

    }else{
        echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Usuario o password incorrectos!
    </div>
    ';
    };

}else{
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del usuario o el password!
    </div>
    ';
};

$guardar_usuario = null;