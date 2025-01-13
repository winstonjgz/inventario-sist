<div class="container is-fluid mb-6">
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Buscar Usuario</h2>

</div>
<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";
        if(isset($_POST['txt_busqueda'])){
            $busqueda=limpiar_cadena($_POST['txt_busqueda']);
        }else{
            $busqueda="";
        }
        $url="index.php?vista=user_search&";
        $registros=15;
        require_once "./php/usuario_buscar.php";
    
    ?>

    <div class="columns">
        <div class="columns">
            <form action="" method="post">
                <input type="hidden" name="modulo_buscar" value="usuario">
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input type="text" class="input is-rounded" name="txt_busqueda" placeholder="Buscar por nombre, apellido, usuario o email" pattern="[a-zA-Z0-9]{1,30}" maxlength="30">
                    </p>
                    <p class="control">
                        <button type="submit" class="button is-info is-rounded">Buscar</button>
                    </p>
                </div>
            </form>
        </div>
    </div>




</div>

