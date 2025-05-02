<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

session_start();

include_once($dir . "/includes/general.php");
include_once($dir . "/includes/security.php");

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if(!isLogged()){
    header("LOCATION: login");
}

$datos = user_info($_SESSION["user_id"]);

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
                <div class="w-100">
                    <div class="d-flex flex-column font1 mt-3 mb-5 ps-4">
                        <div class="d-flex mb-3">
                            <h2>Usuario</h2>
                        </div>
                        <div class="d-flex flex-column flex-md-row mb-3">
                            <div class="d-flex mb-2">
                                <div class="me-4">
                                    <label for="nombre_usuario" class="mb-2">Nombre</label>
                                    <input type="text" id="nombre_usuario" class="form-control" value="<?= $datos["nombre"] ?>" disabled></input>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div>
                                    <label for="email_usuario" class="mb-2">Email</label>
                                    <input type="email" id="email_usuario" class="form-control" value="<?= $datos["email"] ?>" disabled></input>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex d-inline-block mb-3 ms-4">
                            <?php if(check_avatar($_SESSION["user_id"]) == true && file_exists($dir .'/cms/assets/img/avatar/' . $datos["avatar"])){ ?>
                                <img src="<?= $url_site ?>/cms/assets/img/avatar/<?= $datos["avatar"] ?>" class="rounded-circle shadow avatar" alt="avatar"></img>
                            <?php }else{ ?>
                                <img src="<?= $url_site ?>/cms/assets/img/avatar/avatar-settings.png" class="rounded-circle shadow avatar" alt=""></img>
                            <?php } ?>
                        </div>
                        <div class="d-flex d-inline-block">
                            <button type="button" class="btn btn-dark me-3">Cambiar avatar</button>
                            <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-column font1 mt-5 ps-4">
                        <div class="d-flex mb-3">
                            <h2>Empresa</h2>
                        </div>
                        <div class="d-flex flex-column flex-md-row">
                            <div class="d-flex mb-2">
                                <div class="me-4">
                                    <label for="nombre_empresa" class="mb-2">Nombre</label>
                                    <input type="text" id="nombre_empresa" class="form-control" value="<?= $datos["empresa"] ?>" disabled></input>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-4">
                                    <label for="tutor_empresa" class="mb-2">Tutor</label>
                                    <input type="email" id="tutor_empresa" class="form-control" value="<?= $datos["tutor"] ?>" disabled></input>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div>
                                    <label for="contacto_empresa" class="mb-2">Contacto</label>
                                    <input type="email" id="contacto_empresa" class="form-control" value="<?= $datos["contacto"] ?>" disabled></input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <?php include_once($dir . "/cms/includes/footer.php") ?>
    </footer>
</body>

</html>