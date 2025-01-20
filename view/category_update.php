<?php
    require_once "./php/main.php";

    $id=(isset($_GET['id_categoria_up'])) ? $_GET['id_categoria_up'] : 0;
    $id=limpiar_cadena($id);
?>


<div class="container is-fluid mb-6">
    
        <h1 class="title">Categoría</h1>
        <h2 class="subtitle">Editar categoría</h2>

    
</div>

<div class="container pb-6 pt-6">
    <?php
        include './inc/btn_back.php';

        $check_categoria=conexion() -> query('SELECT * FROM categoria WHERE id_categoria="'.$id.'"');
        if($check_categoria->rowCount()> 0){

            $datos_categoria=$check_categoria->fetch();
    ?>


    <div class="form-rest mb-6 mt-6"></div>
    <form action="./php/categoria_editar.php" method="post" class="FormularioAjax" autocomplete="off">
        <input type="hidden" name="id_categoria_up" required value="<?php echo $datos_categoria['id_categoria']; ?>">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label for="">Nombre</label>
                    <input class="input" type="text" name="categoria_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required value="<?php echo $datos_categoria['categoria_nombre']; ?>">
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label for="">Ubicación</label>
                    <input class="input" type="text" name="categoria_ubicacion" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,50}" maxlength="50" required value="<?php echo $datos_categoria['categoria_ubicacion']; ?>">
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
        $check_categoria=null;
     ?>

    
</div>