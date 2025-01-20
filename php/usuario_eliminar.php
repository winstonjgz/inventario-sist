<?php

$user_id_del = limpiar_cadena($_GET['user_id_del']);

//Verificar que el usuario no sea el administrador y exista
$check_usuario = conexion()->query("SELECT id_usuario FROM usuario WHERE id_usuario='$user_id_del' AND id_usuario!='1'");
if ($check_usuario->rowCount() == 1) {

    //Verificar que el usuario exista con registros en productos
    $check_productos = conexion()->query("SELECT fk_usuario_id FROM producto WHERE fk_usuario_id='$user_id_del' LIMIT 1");
    $check_productos->execute([":fk_usuario_id" => $user_id_del]);
    if ($check_productos->rowCount() <= 0) {
        $eliminar_usuario = conexion();
        $eliminar_usuario = $eliminar_usuario->prepare("DELETE from usuario where id_usuario=:id_usuario");
        $eliminar_usuario->execute([":id_usuario" => $user_id_del]);

        if ($eliminar_usuario->rowCount() == 1) {

            echo '
            <div class="notification is-info is-light">
            <strong>¡Operación exitosa!</strong><br>
            Usuario eliminado exitosamente!
            </div>
            ';
        } else {
            echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No podimos eliminar el usuario, por favor intente nuevamente!
            </div>';
        }

        $eliminar_usuario = null;
    } else {
        echo '
        <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No podemos eliminar el usuario porque tiene productos registrados!
        </div>
        ';
    }




    //Eliminar usuario
    conexion()->query("DELETE FROM usuario WHERE id_usuario='$user_id_del'");
   
} else {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    El usuario que intenta eliminar no existe!
    </div>
    ';
}
