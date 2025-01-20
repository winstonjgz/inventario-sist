<?php

require 'env.php';

function conexion() {
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Activa el modo de errores
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Configura el modo de fetch
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die('Error en la conexión: ' . $e->getMessage()); // Manejo básico de errores
    }
}

    // Funcion para verificar datos

    function verificar_datos($filtro, $cadena){
        if(preg_match("/^".$filtro."$/",$cadena)){
            return false;
        }else{
            return true;
        }

    }
    
    //$nombre="Craor";

        
    /*if(verificar_datos("[a-zA-Z]{4,10}",$nombre)){
        echo "Los datos no coinciden";
    }*/

//Sirve para limpiar cadenas de texto
function limpiar_cadena($cadena){
    $cadena = trim($cadena);
    $cadena = stripslashes($cadena);
    $cadena = str_ireplace("<script>","",$cadena);
    $cadena = str_ireplace("</script>","",$cadena);
    $cadena = str_ireplace("<script src>","",$cadena);
    $cadena = str_ireplace("<script type=>","",$cadena);
    $cadena = str_ireplace("SELECT * FROM","",$cadena);
    $cadena = str_ireplace("DELETE FROM","",$cadena);
    $cadena = str_ireplace("INSERT INTO","",$cadena);
    $cadena = str_ireplace("DROP TABLE","",$cadena);
    $cadena = str_ireplace("DROP DATABASE","",$cadena);
    $cadena = str_ireplace("TRUNCATE TABLE","",$cadena);
    $cadena = str_ireplace("SHOW TABLES;","",$cadena);
    $cadena = str_ireplace("SHOW DATABASES;","",$cadena);
    $cadena = str_ireplace("<?php","",$cadena);
    $cadena = str_ireplace("?>","",$cadena);
    $cadena = str_ireplace("--","",$cadena);
    $cadena = str_ireplace("^","",$cadena);
    $cadena = str_ireplace("<","",$cadena);
    $cadena = str_ireplace("[","",$cadena);
    $cadena = str_ireplace("]","",$cadena);
    $cadena = str_ireplace("==","",$cadena);
    $cadena = str_ireplace(";","",$cadena);
    $cadena = str_ireplace("::","",$cadena);
    $cadena = trim($cadena);
    $cadena = stripslashes($cadena);
    return $cadena ;

}
   


//Funcion renombrar fotos en caso que existan fotos seleccionadas con el mismo nombre
function renombrar_fotos($nombre_fotos){
    $nombre_fotos = str_ireplace(" ","_",$nombre_fotos);
    $nombre_fotos = str_ireplace("/","_",$nombre_fotos);
    $nombre_fotos = str_ireplace("#","_",$nombre_fotos);
    $nombre_fotos = str_ireplace("-","_",$nombre_fotos);
    $nombre_fotos = str_ireplace("$","_",$nombre_fotos);
    $nombre_fotos = str_ireplace(".","_",$nombre_fotos);
    $nombre_fotos = str_ireplace(",","_",$nombre_fotos);
    $nombre_fotos."_".rand(0,100);
    return $nombre_fotos;


}


//Funcion paginador de tablas
function paginador_tablas($pagina, $N_paginas, $url, $botones){
    $tabla ='<nav class="pagination is-centered is-rounded"
    role= "navigation" aria-label="pagination">';

    if($pagina<=1){
        $tabla.='
            <a class="pagination-previous is-disabled" disabled >Anterior</a>
            <ul class="pagination-list">
                
        ';
    }else{
        $tabla.='
            <a class="pagination-previous" href="'.$url.($pagina-1).'">Anterior</a>
            <ul class="pagination-list">
                <li><a class="pagination-link" href=".$url.1">1</a></li>
                <li><span class="pagination-ellipsis">&hellip</span></li>
                
        ';
    }

    $ci = 0;
    for($i = $pagina; $i <= $N_paginas; $i++){
        if($ci>=$botones){
            break;
        }

        if($pagina == $i){
            $tabla.='<li><a class="pagination-link is-current" href="'.$url.($i).'">'.$i.'</a></li>';
        }else{
            $tabla.='<li><a class="pagination-link" href="'.$url.($i).'">'.$i.'</a></li>';
        }

        $ci++;
    };


    if($pagina==$N_paginas){
        $tabla.='
        </ul>
        <a class="pagination-next is-disabled" disabled >Siguiente</a>
                
        ';
    }else{
        $tabla.='
                <li><span class="pagination-ellipsis">&hellip</span></li>
                <li><a class="pagination-link" href="'.$url.($N_paginas).'">'.$N_paginas.'</a></li>
            </ul>
            <a class="pagination-next" href="'.$url.($pagina+1).'">Siguiente</a>
            
        ';
    }

    $tabla.='</nav>';
    return $tabla;
}




