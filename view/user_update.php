<?php
    require_once "./php/main.php";

    $id=(isset($_GET['id_up'])) ? $_GET['id_up'] : 0;
    $id=limpiar_cadena($id);
?>


<div class="container is-fluid mb-6">
    <?php if($id==$_SESSION['id']) { ?>
        <h1 class="title">Mi ID</h1>
        <h2 class="subtitle">Editar Mi Cuenta</h2>
    <?php } else{ ?>
        <h1 class="title">Usuario</h1>
        <h2 class="subtitle">Editar Usuario</h2>

    <?php } ?>
</div>

<div class="container pb-6 pt-6">
    <?php
        include './inc/btn_back.php';

        $check_usuario=conexion() -> query('SELECT * FROM usuario WHERE id_usuario="'.$id.'"');
        if($check_usuario->rowCount()> 0){

            $datos_usuario=$check_usuario->fetch();
    ?>


    <div class="form-rest mb-6 mt-6"></div>
    <form action="./php/usuario_editar.php" method="post" class="FormularioAjax" autocomplete="off">
        <input type="hidden" name="id_usuario" required value="<?php echo $datos_usuario['id_usuario']; ?>">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label for="">Nombre</label>
                    <input class="input" type="text" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required value="<?php echo $datos_usuario['usuario_nombre']; ?>">
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label for="">Apellido</label>
                    <input class="input" type="text" name="usuario_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required value="<?php echo $datos_usuario['usuario_apellido']; ?>">
                </div>
            </div>
        </div>
        <div class="columns">

            <div class="column">
                <div class="control">
                    <label for="">Usuario</label>
                    <input class="input" type="text" name="usuario_usuario" pattern="[a-zA-Z]{10,40}" maxlength="40" value="<?php echo $datos_usuario['usuario_usuario']; ?>">
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label for="">email</label>
                    <input class="input" type="email" name="usuario_email" maxlength="70" value="<?php echo $datos_usuario['usuario_email']; ?>">
                </div>
            </div>


        </div>
        <p class="has-text-centered pb-4">
            Si desea actualizar el password de este usuario por favor llene los 2 campos. En caso contrario deje los campos vacios.
        </p>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label for="">Password</label>
                    <input class="input" type="password" name="usuario_password_1" pattern="[a-zA-Z0-9$@.#]{12,100}" maxlength="100">
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label for="">Repetir Password</label>
                    <input class="input" type="password" name="usuario_password_2" pattern="[a-zA-Z0-9$@.#]{12,100}" maxlength="100">
                </div>
            </div>

        </div>

        <p class="has-text-centered pb-4">
            Para poder actualizar los datos del usuario, debe ingresar el usuario y password del administrador del sistema.
        </p>

        <div class="columns">

            <div class="column">
                <div class="control">
                    <label for="">Usuario Administrador</label>
                    <input class="input" type="text" name="administrador_usuario" pattern="[a-zA-Z]{10,40}" maxlength="40" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label for="">Password Administrador</label>
                    <input class="input" type="password" name="administrador_password" pattern="[a-zA-Z0-9$@.#]{12,100}" maxlength="100" required>
                </div>
            </div>



        </div>




        <p class="has-text-centered">
            <button type="submit" class="button is-success is-rounded">
                Actualizar

            </button>
        </p>

    </form>
    <?php } else {
        include "./inc/alerta.php";
     } 
        $check_usuario=null;
     ?>

    
</div>