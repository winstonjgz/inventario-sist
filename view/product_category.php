<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Lista de productos por categoría</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
    require_once './php/main.php';
    ?>

    <div class="columns">
        <div class="column is-one-third">
            <h2 class="title has-text-centered">Categorías</h2>
            <?php
            $categorias = conexion()->query('Select * from categoria');

            if ($categorias->rowCount() > 0) {
                $categorias = $categorias->fetchAll();
                foreach ($categorias as $categoria) {
                    echo '<a href="index.php?vista=product_category&category_id=' . $categoria['id_categoria'] . '" class="button is-link is-inverted is-fullwidth">' . $categoria['categoria_nombre'] . '</a>';
                }
            } else {
                echo '<p class="has-text-centered">No hay categorías registradas</p>';
            }
            $categorias = null;
            ?>

        </div>
        <div class="column">
            <?php
            $categoria_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;

            $categoria_search = conexion()->query("Select * from categoria WHERE id_categoria='$categoria_id'");


            if ($categoria_search->rowCount() > 0) {
                $categoria_search = $categoria_search->fetch();
                echo '<h2 class="title has-text-centered">' . $categoria_search['categoria_nombre'] . '</h2>
            <p class="has-text-centered pb-6">' . $categoria_search['categoria_ubicacion'] . '</p>';

                //Codigo para eliminar producto
                if (isset($_GET['product_id_del'])) {
                    require_once "./php/producto_eliminar.php";
                }

                if (!isset($_GET['page'])) {
                    $pagina = 1;
                } else {
                    $pagina = (int) $_GET['page'];
                    if ($pagina <= 1) {
                        $pagina = 1;
                    }
                }


                $pagina = limpiar_cadena($pagina);
                $url = "index.php?vista=product_category&category_id=$categoria_id&page=";
                $registros = 15;
                $busqueda = "";

                require_once "./php/producto_listar.php";
            } else {
                echo '<h2 class="has-text-centered title">Seleccione una categoría para comenzar</h2>';
            }
            $categoria_search = null;

            ?>

        </div>
    </div>
</div>