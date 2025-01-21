<?php
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

$tabla = "";

$campos = "producto.id_producto, producto.producto_id, producto.producto_nombre, producto.producto_precio, producto.producto_stock, producto.producto_imagen, categoria.categoria_nombre, usuario.usuario_nombre, usuario.usuario_apellido";
$tablas = "";



if (isset($busqueda) && $busqueda != "") {
    $consulta_datos = "SELECT $campos FROM producto INNER JOIN categoria ON producto.fk_categoria_id=categoria.id_categoria INNER JOIN usuario ON producto.fk_usuario_id=usuario.id_usuario  WHERE (producto_nombre LIKE '%$busqueda%' OR producto_id LIKE '%$busqueda%')  
        ORDER BY producto.producto_nombre ASC LIMIT $inicio, $registros";
    $consulta_total = "SELECT COUNT(id_producto) FROM producto WHERE  
        (producto_nombre LIKE '%$busqueda%' OR producto_id LIKE '%$busqueda%')";
}elseif($categoria_id >0){
    $consulta_datos = "SELECT $campos FROM producto INNER JOIN categoria ON producto.fk_categoria_id=categoria.id_categoria INNER JOIN usuario ON producto.fk_usuario_id=usuario.id_usuario  WHERE producto.fk_categoria_id='$categoria_id'
        ORDER BY producto.producto_nombre ASC LIMIT $inicio, $registros";
    $consulta_total = "SELECT COUNT(id_producto) FROM producto WHERE  
        fk_categoria_id='$categoria_id'";
} else {
    $consulta_datos = "SELECT $campos FROM producto INNER JOIN categoria ON producto.fk_categoria_id=categoria.id_categoria INNER JOIN usuario ON producto.fk_usuario_id=usuario.id_usuario ORDER BY producto.producto_nombre ASC LIMIT $inicio, $registros";
    $consulta_total = "SELECT COUNT(id_producto) FROM producto";
}


$conexion = conexion();
$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();

$totales = $conexion->query($consulta_total);
$totales = (int) $totales->fetchColumn();

$Npaginas = ceil($totales / $registros);

if ($totales >= 1 && $pagina <= $Npaginas) {
    $i = 0;
    $contador = $inicio + 1;
    $pag_inicio = $inicio + 1;
    foreach ($datos as $dato) {
        $tabla .= '
                    <article class="media">
                        <figure class="media-left">
                            <p class="image is-64x64">';
                            if(is_file('./img/productos/' . $dato['producto_imagen'])){
                                $tabla .='<img src="./img/productos/' . $dato['producto_imagen'] . '" alt="Imagen del producto">';
                                }else{
                                    $tabla .='<img src="./img/productos/productosf.jpg" alt="Imagen del producto sin foto">';
                                }    
                                    

              $tabla .= '                   
                            </p>
                        </figure>
                        <div class="media-content">
                            <div class="content">
                                <p>
                                <strong>' . $contador . '-'. $dato['producto_nombre'] .  '</strong><br>
                                    <strong> Codigo: </strong> <small>' . $dato['producto_id'] . '</small>
                                    
                                    <strong> Precio: </strong> <small>' . $dato['producto_precio'] . '</small>
                                    
                                    <strong> Stock: </strong> <small>' . $dato['producto_stock'] . '</small>
                                    
                                    <strong> Categoria: </strong> <small>' . $dato['categoria_nombre'] . '</small>
                                    
                                    <strong> Registrado por Usuario: </strong> <small>' . $dato['usuario_nombre'] . ' ' . $dato['usuario_apellido'] . '</small>
                                    
                                </p>
                            </div>
                        </div>
                        <div class="media-right">
                            <div class="field is-grouped">
                                <p class="control">
                                    <a href="index.php?vista=product_img&id_producto=' . $dato['id_producto'] . '" class="button is-info is-rounded is-small">Imagen</a>
                                </p>
                                <p class="control">
                                    <a href="index.php?vista=product_update&id_producto_up=' . $dato['id_producto'] . '" class="button is-info is-rounded is-small">Actualizar</a>
                                </p>
                                <p class="control">
                                    <a href="'.$url.$pagina.'&product_id_del=' . $dato['id_producto'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
                                </p>
                            </div>
                        </div>
                    </article>
                    <hr>';
        $contador++;
    }
    $pag_final = $contador - 1;
} else {
    if ($totales >= 1) {
        $tabla .= '<p class="has-text-centered">
                        <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">Haga click para recargar el listado</a>
                 </p>
                        ';
    } else {
        $tabla .= '<p class="has-text-centered">
                        No hay registros en el sistema
                   </p>
                        ';
    };
}



if ($totales >= 1 && $pagina <= $Npaginas) {
    $tabla .= '<p class="has-text-right">Mostrando productos <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $totales . '</strong></p>';
    

}


$conexion=null;
echo $tabla;

if ($totales >= 1 && $pagina <= $Npaginas) {
    echo paginador_tablas($pagina, $Npaginas, $url, 4);

}