<?php
$modulo_buscador = limpiar_cadena($_POST['modulo_buscador']);
$modulos = [
    'usuario',
    'producto',
    'categoria',

];

if (in_array($modulo_buscador, $modulos)) {
    $modulos_url = [
        'usuario' => 'user_search',
        'producto' => 'product_search',
        'categoria' => 'category_search',
    ];

    $modulos_url = $modulos_url[$modulo_buscador];

    $modulo_buscador = "busqueda_" . $modulo_buscador;

    //Iniciar busqueda
    if (isset($_POST['txt_busqueda'])) {
        $txt = limpiar_cadena($_POST['txt_busqueda']);
        if ($txt == "") {
            echo '
            <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado el campo de busqueda
            </div>
            ';
        } else {
            if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚÑñ ]{1,30}", $txt)) {
                echo '
               <div class="notification is-danger is-light">
               <strong>¡Ocurrio un error inesperado!</strong><br>
               La busqueda tiene caracteres no reconocidos!!
               </div>
               ';
            } else {
                $_SESSION[$modulo_buscador] = $txt;
                header("Location: index.php?vista=$modulos_url", true, 303);
                exit();
            }
        }
    }

    //Eliminar busqueda
    if (isset($_POST['eliminar_buscar']) ) {
        unset($_SESSION[$modulo_buscador]);
        header("Location: index.php?vista=$modulos_url", true, 303);
        exit();
    }
} else {
    echo '
    <div class="notification is-danger is-light">
    <strong>¡Ocurrio un error inesperado!</strong><br>
    No podemos procesar la petición!
    </div>
    ';
};
