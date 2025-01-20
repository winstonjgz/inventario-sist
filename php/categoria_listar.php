<?php
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

$tabla = "";

if (isset($busqueda) && $busqueda != "") {
    $consulta_datos = "SELECT * FROM categoria WHERE 
        (categoria_nombre LIKE '%$busqueda%' OR categoria_ubicacion LIKE '%$busqueda%')  
        ORDER BY categoria_nombre ASC LIMIT $inicio, $registros";
    $consulta_total = "SELECT COUNT(id_categoria) FROM categoria WHERE  
        (categoria_nombre LIKE '%$busqueda%' OR categoria_ubicacion LIKE '%$busqueda%')";
} else {
    $consulta_datos = "SELECT * FROM categoria ORDER BY categoria_nombre ASC LIMIT $inicio, $registros";
    $consulta_total = "SELECT COUNT(id_categoria) FROM categoria";
}


$conexion = conexion();
$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();

$totales = $conexion->query($consulta_total);
$totales = (int) $totales->fetchColumn();

$Npaginas = ceil($totales / $registros);

$tabla .= '<div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Ubicación</th>
                    <th>Productos</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>';

if ($totales >= 1 && $pagina <= $Npaginas) {
    $i = 0;
    $contador = $inicio + 1;
    $pag_inicio = $inicio + 1;
    foreach ($datos as $dato) {
        $tabla .= '<tr class="has-text-centered">
                    <td>' . $contador . '</td>
                    <td>' . $dato['categoria_nombre'] . '</td>
                    <td>' . $dato['categoria_ubicacion'] . '</td>
                    <td><a href="index.php?vista=product_category&category_list='.$dato['categoria_nombre'].'" class="button is-link is-rounded is-small">Ver Productos</a></td>
                    <td><a href="index.php?vista=category_update&id_categoria_up=' . $dato['id_categoria'] . '" class="button is-info is-rounded is-small">Editar</a></td>
                    <td><a href="'.$url.$pagina.'&category_id_del=' . $dato['id_categoria'] . '" class="button is-danger is-rounded is-small">Eliminar</a></td>
                    
                </tr>';
        $contador++;
    }
    $pag_final = $contador - 1;
} else {
    if ($totales >= 1) {
        $tabla .= '<tr class="has-text-centered">
                    <td colspan="7">
                        <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">Haga click para recargar el listado</a>
                    </td>
                    </tr>';
    } else {
        $tabla .= '<tr class="has-text-centered">
                    <td colspan="7">
                        No hay registros en el sistema
                    </td>
                    </tr>';
    };
}





$tabla .= '</tbody></table></div>';

if ($totales >= 1 && $pagina <= $Npaginas) {
    $tabla .= '<p class="has-text-right">Mostrando categorias <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $totales . '</strong></p>';
    

}


$conexion=null;
echo $tabla;

if ($totales >= 1 && $pagina <= $Npaginas) {
    echo paginador_tablas($pagina, $Npaginas, $url, 4);

}