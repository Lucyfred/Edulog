<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");
include_once($dir . "/includes/security.php");
include_once($dir . "/cms/includes/checkeo.php");
include_once($dir . "/cms/includes/showErrors.php");

if (rol($_SESSION["user_id"]) === 3) {
    $fichas = get_all_sheets_filter($_SESSION["user_id"]);
}

if (rol($_SESSION["user_id"]) === 1) {
    $last_login = last_login_users_list();
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
                <div class="d-flex justify-content-center align-items-center w-100 h-100" id="div-loader">
                    <div>
                        <?php include_once($dir . "/cms/includes/loader.php") ?>
                    </div>
                </div>
                <div class="w-100" id="div-content">
                    <?php if (rol($_SESSION["user_id"]) === 1): ?>
                        <div class="m-4">
                            <h3>Últimos usuarios logueados</h3>
                        </div>
                        <div class="d-flex flex-row flex-wrap mt-2 ms-4">
                            <table class="table text-white table-striped table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Centro</th>
                                        <th scope="col">Empresa</th>
                                        <th scope="col">Último login</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    <?php if (count($last_login) > 0) { ?>
                                        <?php foreach ($last_login as $user): ?>
                                            <tr>
                                                <td scope="col"><?= $user["nombre"] ?></td>
                                                <td scope="col"><?= $user["email"] ?></td>
                                                <td scope="col"><?= $user["centro"] ?></td>
                                                <td scope="col"><?= $user["empresa"] ?></td>
                                                <td scope="col"><?= ($user["last_login"]) ? fecha_normal_hora($user["last_login"]) : "" ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td class="text-center" colspan="5">
                                                <div class="alert alert-warning">No se han encontrado registros</div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                    <?php if (rol($_SESSION["user_id"]) === 3): ?>
                        <div class="m-4">
                            <h3>Últimas fichas creadas</h3>
                        </div>
                        <div class="d-flex flex-row flex-wrap mt-2 ms-4">
                            <?php if (count($fichas) > 0) { ?>
                                <?php foreach ($fichas as $ficha): ?>
                                    <?php include($dir . "/cms/includes/card_ficha.php") ?>
                                <?php endforeach; ?>
                            <?php } else { ?>
                                <div class="alert alert-warning ms-4">No se ha encontrado ninguna ficha</div>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <footer>
        <?php include_once($dir . "/cms/includes/footer.php") ?>
    </footer>

    <script>
        $(window).on("load", function() {
            $("#div-loader").addClass("d-none");
            $("#div-content").removeClass("d-none");
        })
    </script>
</body>

</html>