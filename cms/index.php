<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");
include_once($dir . "/includes/security.php");
include_once($dir . "/cms/includes/checkeo.php");
include_once($dir . "/cms/includes/showErrors.php");

$fichas = get_all_sheets_filter($_SESSION["user_id"]);
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
                <div class="m-4">
                    <h3>Últimas fichas creadas</h3>
                </div>
                <!-- <div class="mt-2 ms-4">
                    <?php if (count($fichas) > 0) { ?>
                        <?php foreach ($fichas as $ficha): ?>
                            <?php include_once($dir . "/cms/includes/card_ficha.php") ?>
                        <?php endforeach; ?>
                    <?php } else { ?>
                        <div class="alert alert-warning ms-4">No se ha encontrado ninguna ficha</div>
                    <?php } ?>
                </div> -->
            </div>

        </div>
    </div>

    <footer>
        <?php include_once($dir . "/cms/includes/footer.php") ?>
    </footer>
</body>

</html>