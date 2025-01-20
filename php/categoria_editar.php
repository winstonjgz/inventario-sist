<?php
require_once "../inc/session_start.php";
require_once "main.php";

$id = limpiar_cadena($_POST['id_usuario']);

//Verificar si existe el usuario en la base de datos
$check_usuario = conexion()->query('SELECT * FROM usuario WHERE id_usuario="' . $id . '"');

if ($check_usuario->rowCount() <= 0) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Usuario no existe!
    </div>
    ';
    exit();
} else {
    $datos = $check_usuario->fetch();
}

$check_usuario = null;

$admin_usuario = limpiar_cadena($_POST['administrador_usuario']);
$admin_password = limpiar_cadena($_POST['administrador_password']);

if ($admin_usuario == "" || $admin_password == "") {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
   Los datos del administrador para guardar la informacion son obligatorios!
    </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-Z]{10,40}", $admin_usuario)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del usuario con el formato requerido!
    </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-Z0-9$@.#]{12,100}", $admin_password)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrió un error inesperado!</strong><br>
    Existe un error con los password con el formato requerido.
    </div>
    ';
    exit();
}


//Verificando el administrador
$check_admin = conexion()->prepare('SELECT usuario_usuario, usuario_password FROM usuario WHERE usuario_usuario=:admin_usuario AND id_usuario=:id');
$check_admin->bindParam(':admin_usuario', $admin_usuario, PDO::PARAM_STR);
$check_admin->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
$check_admin->execute();

if ($check_admin->rowCount() == 1) {
    $check_admin = $check_admin->fetch();

    if (!password_verify($admin_password, $check_admin['usuario_password'])) {
        echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrió un error inesperado!</strong><br>
    Existe un error con los password con el formato requerido.
    </div>
    ';
        exit();
    }
} else {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrió un error inesperado!</strong><br>
    Usuario y password no tienen acceso de administrador para actualizar esta cuenta!
    </div>
    ';
    exit();
}

$check_admin = null;

//Almacenando datos

$nombre = limpiar_cadena($_POST['usuario_nombre']);
$apellido = limpiar_cadena($_POST['usuario_apellido']);
$usuario = limpiar_cadena($_POST['usuario_usuario']);
$email = limpiar_cadena($_POST['usuario_email']);
$password1 = limpiar_cadena($_POST['usuario_password_1']);
$password2 = limpiar_cadena($_POST['usuario_password_2']);

if ($nombre == "" || $apellido  == "" || $usuario  == "") {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No has llenado todos los campos que son obligatorios
    </div>
    ';
    exit();
}


//Verificar integridad de los datos
if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del nombre con el formato requerido!
    </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del apellido con el formato requerido!
    </div>
    ';
    exit();
}

if (verificar_datos("[a-zA-Z]{10,40}", $usuario)) {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    Existe un error del usuario con el formato requerido!
    </div>
    ';
    exit();
}

// Verificando el email
if ($email != "" && $email != $datos['usuario_email']) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $check_email = conexion();
        $check_email = $check_email->query("SELECT usuario_email FROM usuario WHERE usuario_email = '$email'");
        if ($check_email->rowCount() > 0) {
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
    } else {
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
if ($usuario != $datos['usuario_usuario']) {
    $check_usuario = conexion();
    $check_usuario = $check_usuario->query("SELECT usuario_usuario FROM usuario WHERE usuario_usuario = '$usuario'");
    if ($check_usuario->rowCount() > 0) {
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
}

//Verificacion de contraseñas
if ($password1 != '' || $password2 != '') {
    if (verificar_datos("[a-zA-Z0-9$@.#]{12,100}", $password1) || verificar_datos("[a-zA-Z0-9$@.#]{12,100}", $password2)) {
        echo '
        <div class="notification is-danger is-light">
        <strong>¡Ocurrió un error inesperado!</strong><br>
        Existe un error con los password con el formato requerido.
        </div>
        ';
        exit();
    } else {
        if ($password1 != $password2) {
            echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Los password no son iguales!
            Por favor verifique!
            </div>
            ';
            exit();
        } else {
            $password = password_hash($password1, PASSWORD_BCRYPT, ["cost" => 10]);
        }
    }
} else {
    $password = $datos['usuario_password'];
}

//Actualizando datos
$actualizar_usuario = conexion()->prepare('UPDATE usuario SET usuario_nombre=:nombre, usuario_apellido=:apellido, usuario_usuario=:usuario, usuario_email=:email, usuario_password=:password WHERE id_usuario=:id');

$marcadores = [
    ":nombre" => $nombre,
    ":apellido" => $apellido,
    ":usuario" => $usuario,
    ":password" => $password,
    ":email" => $email,
    ":id" => $id,
];




if ($actualizar_usuario->execute($marcadores)) {
    echo '
    <div class="notification is-info is-light">
    <strong>¡Actualización exitosa!</strong><br>
    El usuario fue actualizado exitosamente!
    </div>
    ';
} else {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No se pudo actualizar el usuario!
    Por favor verifique!
    </div>
    ';
}

$actualizar_usuario = null;
