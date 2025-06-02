<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");
include_once($dir . "/includes/security.php");
include_once($dir . "/cms/includes/checkeo.php");
include_once($dir . "/cms/includes/showErrors.php");

// Ejecutamos las funciones según el rol del usuario
if (rol($_SESSION["user_id"]) === 3) {
    $fichas = get_all_sheets_filter($_SESSION["user_id"]);
}

if (rol($_SESSION["user_id"]) === 1) {
    $last_login = last_login_users_list();
}

// Index, donde se mostrará la página principal para el alumno se mostrará sus últimas fichas
// y para el administrador se mostrarán los últimos últimos 6 login de los alumnos
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

    <!-- Modal editar -->
    <div class="modal fade" id="modal-editar" tabindex="-1" aria-labelledby="modalEditar" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-black" id="modalEditar">Editar ficha semanal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <form id="form-editar" method="POST">
                            <div class="row">
                                <div class="col-9">
                                    <label class="form-label text-black" for="fecha">Actividad lunes:</label>
                                    <textarea class="form-control" rows="3" name="act-lunes" id="textarea-lunes"></textarea>
                                </div>
                                <div class="col-3">
                                    <label class="form-label text-black" for="fecha">Horas:</label>
                                    <input type="number" class="form-control" name="h-lunes" id="horas-lunes"></input>
                                </div>
                            </div>
                            <hr class="text-black">
                            <div class="row">
                                <div class="col-9">
                                    <label class="form-label text-black" for="fecha">Actividad martes:</label>
                                    <textarea class="form-control" rows="3" name="act-martes" id="textarea-martes"></textarea>
                                </div>
                                <div class="col-3">
                                    <label class="form-label text-black" for="fecha">Horas:</label>
                                    <input type="number" class="form-control" name="h-martes" id="horas-martes"></input>
                                </div>
                            </div>
                            <hr class="text-black">
                            <div class="row">
                                <div class="col-9">
                                    <label class="form-label text-black" for="fecha">Actividad miércoles:</label>
                                    <textarea class="form-control" rows="3" name="act-miercoles" id="textarea-miercoles"></textarea>
                                </div>
                                <div class="col-3">
                                    <label class="form-label text-black" for="fecha">Horas:</label>
                                    <input type="number" class="form-control" name="h-miercoles" id="horas-miercoles"></input>
                                </div>
                            </div>
                            <hr class="text-black">
                            <div class="row">
                                <div class="col-9">
                                    <label class="form-label text-black" for="fecha">Actividad jueves:</label>
                                    <textarea class="form-control" rows="3" name="act-jueves" id="textarea-jueves"></textarea>
                                </div>
                                <div class="col-3">
                                    <label class="form-label text-black" for="fecha">Horas:</label>
                                    <input type="number" class="form-control" name="h-jueves" id="horas-jueves"></input>
                                </div>
                            </div>
                            <hr class="text-black">
                            <div class="row">
                                <div class="col-9">
                                    <label class="form-label text-black" for="fecha">Actividad viernes:</label>
                                    <textarea class="form-control" rows="3" name="act-viernes" id="textarea-viernes"></textarea>
                                </div>
                                <div class="col-3">
                                    <label class="form-label text-black" for="fecha">Horas:</label>
                                    <input type="number" class="form-control" name="h-viernes" id="horas-viernes"></input>
                                </div>
                            </div>
                            <br>
                            <button type="button" class="btn btn-success" id="btn-save">Guardar</button>
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
        /**
         * Evento de carga, al cargar la web, oculta el loader y muestra la web
         */
        $(window).on("load", function() {
            $("#div-loader").addClass("d-none");
            $("#div-content").removeClass("d-none");
        })
    </script>
</body>

</html>