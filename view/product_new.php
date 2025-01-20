<div class="container is-fluid mb-6">
    <h1 class="title">Producto</h1>
    <h2 class="subtitle">Nuevo Producto</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
    require_once './php/main.php';
    ?>


    <div class="form-rest mb-6 mt-6"></div>
    <!-- Se agrega multipart para poder agregar imagenes en el FormularioAjax -->
    <form action="./php/producto_guardar.php" method="post" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label for="">Codigo</label>
                    <input class="input" type="text" name="producto_codigo" pattern="[a-zA-Z0-9 ]{1,70}" maxlength="70" required>
                </div>
            </div>


            <div class="column">
                <div class="control">
                    <label for="">Nombre</label>
                    <input class="input" type="text" name="producto_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                </div>
            </div>
        </div>
        <div class="columns">

            <div class="column">
                <div class="control">
                    <label for="">Precio</label>
                    <input class="input" type="text" name="producto_precio" pattern="[0-9.]{1,20}" maxlength="20" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label for="">Stock</label>
                    <input class="input" type="text" name="producto_stock" pattern="[0-9.]{1,20}" maxlength="20" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label for="">Categoria</label>
                    <br>
                    <div class="select is-rounded">
                        <select name="producto_categoria">
                            <option value="" selected="">Seleccione una opción</option>
                            <?php
                            $categorias = conexion()->query('Select * from categoria');

                            if ($categorias->rowCount() > 0) {
                                $categorias = $categorias->fetchAll();
                                foreach ($categorias as $categoria) {
                                    echo '<option value="' . $categoria['id_categoria'] . '">' . $categoria['categoria_nombre'] . '</option>';
                                }
                            }
                            $categorias = null;
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


</div>




</div>
<p class="has-text-centered">
    <button type="submit" class="button is-info is-rounded">
        Guardar

    </button>
</p>

</form>
</div>