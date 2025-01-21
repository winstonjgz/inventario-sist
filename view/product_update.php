<?php
    require_once "./php/main.php";

    $id=(isset($_GET['id_producto_up'])) ? $_GET['id_producto_up'] : 0;
    $id=limpiar_cadena($id);
?>


<div class="container is-fluid mb-6">
    
        <h1 class="title">Categoría</h1>
        <h2 class="subtitle">Editar categoría</h2>

    
</div>

<div class="container pb-6 pt-6">
    <?php
        include './inc/btn_back.php';

        $check_producto=conexion() -> query('SELECT * FROM producto WHERE id_producto="'.$id.'"');
        if($check_producto->rowCount()> 0){

            $datos_producto=$check_producto->fetch();
    ?>


    <div class="form-rest mb-6 mt-6"></div>
    <form action="./php/producto_editar.php" method="post" class="FormularioAjax" autocomplete="off">
    <div class="columns">
            <div class="column">
                <div class="control">
                    <label for="">Codigo</label>
                    <input class="input" type="text" name="producto_codigo" value="<?php echo $datos_producto['producto_codigo'] ?>" pattern="[a-zA-Z0-9 ]{1,70}" maxlength="70" required>
                </div>
            </div>


            <div class="column">
                <div class="control">
                    <label for="">Nombre</label>
                    <input class="input" type="text" name="producto_nombre" value="<?php echo $datos_producto['producto_nombre'] ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                </div>
            </div>
        </div>
        <div class="columns">

            <div class="column">
                <div class="control">
                    <label for="">Precio</label>
                    <input class="input" type="text" name="producto_precio" value="<?php echo $datos_producto['producto_precio'] ?>" pattern="[0-9.]{1,20}" maxlength="20" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label for="">Stock</label>
                    <input class="input" type="text" name="producto_stock" value="<?php echo $datos_producto['producto_stock'] ?>" pattern="[0-9.]{1,20}" maxlength="20" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label for="">producto</label>
                    <br>
                    <div class="select is-rounded">
                        <select name="producto_producto">
                            <option value="<?php echo $datos_producto['fk_producto_id'] ?>" selected=""><?php echo $datos_producto['producto_nombre'] ?></option>
                            <?php
                            $productos = conexion()->query('Select * from producto');

                            if ($productos->rowCount() > 0) {
                                $productos = $productos->fetchAll();
                                foreach ($productos as $producto) {
                                    echo '<option value="' . $producto['id_producto'] . '">' . $producto['producto_nombre'] . '</option>';
                                }
                            }
                            $productos = null;
                            ?>

                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">

                <label for="">Imagen</label>
                <div class="file is-small has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="producto_imagen" accept=".jpg, .png, .jpeg" required>
                        <span class="file-cta">
                            <span class="file-label">
                                Seleccionar Imagen
                            </span>
                        </span>
                        <span class="file-name">
                            JPG, JPEG, PNG (Max 3MB)
                        </span>
                    </label>


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
        $check_producto=null;
     ?>

    
</div>