<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");
include_once($dir . "/includes/security.php");


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if(!isLogged()){
    header("LOCATION: login");
}

if(first_login($_SESSION["user_id"]) === 0){
    header("LOCATION: datos");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include_once($dir . "/cms/includes/head.php") ?>
</head>
<body>
    <div class="container-fluid fp">

        <?php include_once($dir . "/cms/includes/navbar.php") ?>

        <div class="container-bott d-flex flex-row h-100">

            <?php include_once($dir . "/cms/includes/menu-lateral.php") ?>

            <div class="main-frame p-4" id="content-frame">
                
            </div>
        </div>
    </div>

    <footer>
        <?php include_once($dir . "/cms/includes/footer.php") ?>
    </footer>
</body>
</html>