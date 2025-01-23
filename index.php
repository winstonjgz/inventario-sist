<?php
require "./inc/session_start.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    if ((!isset($_SESSION['id']) || $_SESSION['id'] == "") || (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")) {

        include "./inc/head_login.php";
    } else {
        include "./inc/head.php";
    }

    ?>
</head>

<body>
    <?php

    if (!isset($_GET['vista']) || ($_GET['vista']) == "") {
        $_GET['vista'] = "login";
    }

    if (is_file("./view/" . $_GET['vista'] . ".php") && $_GET['vista'] != "login" && $_GET['vista'] != "404") {
        #Cerrar sesion forzada
        if ((!isset($_SESSION['id']) || $_SESSION['id'] == "") || (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "")) {

            include "./view/logout.php";
            exit();
        }
        include "./inc/navbar.php";
        include "./view/" . $_GET['vista'] . ".php";
        include "./inc/script.php";
    } else {
        if ($_GET['vista'] == 'login') {
            include "./view/login.php";
        } else {
            include "./view/404.php";
        }
    }


    ?>

</body>

</html>