<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");
include_once($dir . "/cms/includes/checkeo.php");

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
                    <div class="d-flex justify-content-end">
                        <div class="me-3">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Crear</button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="formulario-pdf">
                                    <form action="<?= $url_site ?>/cms/includes/generar_ficha.php" method="POST">
                                        <label class="form-label text-black" for="nombre">Nombre:</label>
                                        <input class="form-control" type="text" name="inp-nombre" id="nombre">
                                        <br>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
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