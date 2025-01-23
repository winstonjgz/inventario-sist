<?php
require_once "./php/main.php";

$id = (isset($_GET['id_producto_up'])) ? $_GET['id_producto_up'] : 0;
$id = limpiar_cadena($id);
?>


<div class="container is-fluid mb-6">

    <h1 class="title">Producto</h1>
    <h2 class="subtitle">Editar Imagen de Producto</h2>


</div>

<div class="container pb-6 pt-6">
    <?php
    include './inc/btn_back.php';

    $check_producto = conexion()->query('SELECT * FROM producto WHERE id_producto="' . $id . '"');
    if ($check_producto->rowCount() > 0) {

        $datos_producto = $check_producto->fetch();
    ?>


        <div class="form-rest mb-6 mt-6"></div>


        <div class="columns">
            <div class="column is-two-fifths">
                <?php
                if (is_file("./img/productos/" . $datos_producto['producto_imagen'])) {
                ?>
                    <figure class="image mb-6">
                        <img src="./img/productos/<?php echo $datos_producto['producto_imagen'] ?>" alt="<?php echo $datos_producto['producto_nombre'] ?>" style="max-width: 100%; max-height: 100%; border-radius: 10px;">
                    </figure>
                    <form action="./php/producto_eliminar_img.php" method="post" class="FormularioAjax" autocomplete="off">
                        <input type="hidden" name="id_producto_del" value="<?php echo $datos_producto['id_producto']; ?>">
                        <p class="has-text-centered">
                            <button type="submit" class="button is-danger is-rounded">
                                Eliminar Imagen
                            </button>
                        </p>
                    </form>
                <?php } else { ?>
                    <figure class="image mb-6">
                        <img src="./img/productos/productosf.jpg" alt="Producto sin foto" style="max-width: 50%; max-height: 50%;">
                    </figure>
                <?php } ?>
            </div>
            <div class="column is-two-fifths">
                <form action="./php/producto_editar_img.php" method="post" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">

                    <h4 class="title has-text-centered"><?php echo strtoupper($datos_producto['producto_nombre']); ?></h4>
                    <label for="">Foto o imagen del producto</label>
                    <input type="hidden" name="id_producto_up" value="<?php echo $datos_producto['id_producto']; ?>">
                    <div class="file has-name is-fullwidth">
                        <label class="file-label"><br>
                            <input class="file-input" type="file" name="producto_imagen" accept=".jpg, .png, .jpeg" required>
                            <span class="file-cta">
                                <span class="file-icon">
                                    <i class="fa-solid fa-upload"></i>
                                </span>
                                <span class="file-label">
                                    Seleccionar Imagen
                                </span>
                            </span>
                            <span class="file-name">
                                JPG, JPEG, PNG (Max 3MB)
                            </span>
                        </label>
                    </div>
                    <br>
                    <p class="has-text-centered">
                        <button type="submit" class="button is-success is-rounded">
                            Actualizar
                        </button>
                    </p>
                </form>
            </div>
        <?php } else {
        include "./inc/alerta.php";
    }
    $check_producto = null;
        ?>


        </div>