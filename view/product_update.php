<?php
require_once "./php/main.php";

$id = (isset($_GET['id_producto_up'])) ? $_GET['id_producto_up'] : 0;
$id = limpiar_cadena($id);
?>


<div class="container is-fluid mb-6">

    <h1 class="title">Producto</h1>
    <h2 class="subtitle">Editar Producto</h2>


</div>

<div class="container pb-6 pt-6">
    <?php
    include './inc/btn_back.php';

    $check_producto = conexion()->query('SELECT * FROM producto 
                                            JOIN categoria ON categoria.id_categoria=producto.fk_categoria_id
                                            WHERE id_producto="' . $id . '"');
    if ($check_producto->rowCount() > 0) {

        $datos_producto = $check_producto->fetch();
    ?>


        <div class="form-rest mb-6 mt-6"></div>
        <h2 class="title has-text-centered"><?php
                                            echo strtoupper($datos_producto['producto_nombre']);
                                            ?></h2>

        <form action="./php/producto_editar.php" method="post" class="FormularioAjax" autocomplete="off">
            <input type="hidden" name="id_producto_up" required value="<?php echo $datos_producto['id_producto']; ?>">
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label for="">Código</label>
                        <input class="input" type="text" name="producto_codigo" value="<?php echo $datos_producto['producto_id'] ?>" pattern="[a-zA-Z0-9 ]{1,70}" maxlength="70" required>
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
                        <label for="">Categoría</label>
                        <br>
                        <div class="select is-rounded">
                            <select name="producto_categoria">

                                <?php
                                $categorias = conexion()->query('Select * from categoria');

                                if ($categorias->rowCount() > 0) {
                                    $categorias = $categorias->fetchAll();
                                    foreach ($categorias as $categoria) {
                                        if ($categoria['id_categoria'] == $datos_producto['fk_categoria_id']) {

                                            echo '<option value="' . $datos_producto['fk_categoria_id'] . '" selected="">' . $datos_producto['categoria_nombre'] . '</option>';
                                        } else {
                                            echo '<option value="' . $categoria['id_categoria'] . '">' . $categoria['categoria_nombre'] . '</option>';
                                        }
                                    }
                                    $categorias = null;
                                }
                                ?>

                            </select>
                        </div>
                    </div>
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
    $check_producto = null;
?>


</div>