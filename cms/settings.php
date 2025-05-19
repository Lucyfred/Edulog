<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

// session_start();

include_once($dir . "/includes/general.php");
include_once($dir . "/includes/security.php");
include_once($dir . "/cms/includes/checkeo.php");
include_once($dir . "/cms/includes/showErrors.php");


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
                <div class="d-flex justify-content-center align-items-center w-100 h-100" id="div-loader">
                    <div>
                        <?php include_once($dir . "/cms/includes/loader.php") ?>
                    </div>
                </div>
                <div class="w-100 d-none" id="div-content">
                    <div class="d-flex flex-column font1 mt-3 mb-4 ps-4">
                        <div class="d-flex mb-3">
                            <h2>Usuario</h2>
                        </div>
                        <div class="d-flex mb-3">
                            <form class="d-flex flex-column flex-md-row" id="form-user-data">
                                <div class="d-flex mb-3">
                                    <div class="me-4">
                                        <label for="nombre_usuario" class="mb-2">Nombre</label>
                                        <input type="text" id="nombre_usuario" class="form-control" name="inp-nombre-usuario" value="<?= $datos["nombre"] ?>" disabled></input>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="me-4">
                                        <label for="email_usuario" class="mb-2">Email</label>
                                        <input type="email" id="email_usuario" class="form-control" name="inp-email-usuario" value="<?= $datos["email"] ?>" disabled></input>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div>
                                        <label for="pass_usuario" class="mb-2">Contraseña</label><br>
                                        <button type="button" id="btn_pass_usuario" class="form-control btn btn-warning w-btn" data-bs-toggle="modal" data-bs-target="#modal-editar-password"> Cambiar contraseña</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="d-flex d-inline-block mb-3 ms-4">
                            <input type="hidden" id="id_user" value="<?= $_SESSION["user_id"] ?>">
                            <?php if (check_avatar($_SESSION["user_id"]) == true && file_exists($dir . '/cms/assets/img/avatar/' . $datos["avatar"])) { ?>
                                <img src="<?= $url_site ?>/cms/assets/img/avatar/<?= $datos["avatar"] ?>" class="rounded-circle shadow avatar" id="avatar"></img>
                            <?php } else { ?>
                                <img src="<?= $url_site ?>/cms/assets/img/avatar/avatar-settings.png" class="rounded-circle shadow avatar" id="avatar"></img>
                            <?php } ?>
                        </div>
                        <div class="d-flex d-inline-block">
                            <input type="file" id="avatar-file" style="display: none;">
                            <button type="file" class="btn btn-dark me-3" id="upload-avatar" onclick="document.getElementById('avatar-file').click();">Cambiar avatar</button>
                            <button type="button" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                    <div class="d-flex flex-column font1 mt-3 ps-4">
                        <div class="d-flex flex-column flex-md-row">
                            <div class="d-flex mb-2">
                                <div class="me-4" id="div-edit-user">
                                    <button class="btn btn-primary" id="btn-edit-user">Editar</button>
                                </div>
                                <div class="me-4 d-none" id="div-accept-user">
                                    <button class="btn btn-success" id="btn-accept-user">Aceptar</button>
                                </div>
                                <div class="me-4 d-none" id="div-cancel-user">
                                    <button class="btn btn-danger" id="btn-cancel-user">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (rol($_SESSION["user_id"]) === 3): ?>
                        <hr>
                        <div class="d-flex flex-column font1 mt-3 ps-4">
                            <div class="d-flex mb-3">
                                <h2>Centro</h2>
                            </div>
                            <div class="d-flex">
                                <form class="d-flex flex-column flex-md-row" id="form-center-data">
                                    <div class="d-flex mb-3">
                                        <div class="me-4">
                                            <label for="nombre_centro" class="mb-2">Nombre</label>
                                            <input type="text" id="nombre_centro" class="form-control" name="inp-nombre-centro" value="<?= $datos["centro"] ?>" disabled></input>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="me-4">
                                            <label for="tutor_centro" class="mb-2">Tutor</label>
                                            <input type="email" id="tutor_centro" class="form-control" name="inp-tutor-centro" value="<?= $datos["tutor_centro"] ?>" disabled></input>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="me-4">
                                            <label for="fp" class="mb-2">Ciclo formativo</label>
                                            <input type="text" id="fp" class="form-control" name="inp-fp" value="<?= $datos["fp"] ?>" disabled></input>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="d-flex flex-column font1 mt-3 ps-4">
                            <div class="d-flex flex-column flex-md-row">
                                <div class="d-flex mb-2">
                                    <div class="me-4" id="div-edit-centro">
                                        <button class="btn btn-primary" id="btn-edit-centro">Editar</button>
                                    </div>
                                    <div class="me-4 d-none" id="div-accept-centro">
                                        <button class="btn btn-success" id="btn-accept-centro">Aceptar</button>
                                    </div>
                                    <div class="me-4 d-none" id="div-cancel-centro">
                                        <button class="btn btn-danger" id="btn-cancel-centro">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-column font1 mt-3 ps-4">
                            <div class="d-flex mb-3">
                                <h2>Empresa</h2>
                            </div>
                            <div class="d-flex">
                                <form class="d-flex flex-column flex-md-row" id="form-lab-data">
                                    <div class="d-flex mb-3">
                                        <div class="me-4">
                                            <label for="nombre_lab" class="mb-2">Nombre</label>
                                            <input type="text" id="nombre_lab" class="form-control" name="inp-nombre-lab" value="<?= $datos["empresa"] ?>" disabled></input>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="me-4">
                                            <label for="tutor_lab" class="mb-2">Tutor</label>
                                            <input type="email" id="tutor_lab" class="form-control" name="inp-tutor-lab" value="<?= $datos["tutor_empresa"] ?>" disabled></input>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="d-flex flex-column font1 mt-3 ps-4">
                            <div class="d-flex flex-column flex-md-row">
                                <div class="d-flex mb-2">
                                    <div class="me-4" id="div-edit-lab">
                                        <button class="btn btn-primary" id="btn-edit-lab">Editar</button>
                                    </div>
                                    <div class="me-4 d-none" id="div-accept-lab">
                                        <button class="btn btn-success" id="btn-accept-lab">Aceptar</button>
                                    </div>
                                    <div class="me-4 d-none" id="div-cancel-lab">
                                        <button class="btn btn-danger" id="btn-cancel-lab">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal editar contraseña -->
    <div class="modal fade" id="modal-editar-password" tabindex="-1" aria-labelledby="modalEditPassword" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-black" id="modalEditPassword">Cambiar contraseña</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <form id="form-edit-pass" method="POST">
                            <label class="form-label text-black" for="pass">Contraseña:</label>
                            <input class="form-control" type="password" name="inp-pass" id="pass">
                            <br>
                            <label class="form-label text-black" for="pass2">Confirmar contraseña:</label>
                            <input class="form-control" type="password" name="inp-pass2" id="pass2">
                            <br>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success btn-success-password" id="btn-edit-password">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <?php include_once($dir . "/cms/includes/footer.php") ?>
    </footer>

    <script>
        $(window).on("load", function(){
            $("#div-loader").addClass("d-none");
            $("#div-content").removeClass("d-none");
        })
    </script>
</body>

</html>