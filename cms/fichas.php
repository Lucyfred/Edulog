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
                <?php if (rol($_SESSION["user_id"]) === 1): ?>
                    <div class="d-flex flex-row w-100 mt-3">
                        <div class="d-flex flex-column m-2  w-100" id="div-fichas">
                            <?php
                            $ultimo_centro = null;
                            foreach (get_all_schools() as $centro):
                            ?>
                                <?php if (strtolower($centro["nombre"]) !== $ultimo_centro): ?>
                                    <div class="d-flex">
                                        <h2 class="ms-4 mb-4 div-centro"><?= $centro["nombre"] ?></h2>
                                    </div>
                                <?php
                                endif;
                                $ultimo_centro = strtolower($centro["nombre"]);
                                ?>
                                <?php foreach (get_all_students($centro["id_centro"]) as $alumno): ?>
                                    <div class="d-flex flex-column alert">
                                        <h3 class="ms-4 mb-4"><?= $alumno["nombre"] ?></h3>
                                        <div class="d-flex flex-wrap flex-md-row flex-column">
                                            <?php $fichas = get_all_sheets($alumno["id_usuario"]) ?>
                                            <?php if (count($fichas) > 0) { ?>
                                                <?php foreach ($fichas as $ficha): ?>
                                                    <?php include_once($dir . "/cms/includes/card_ficha_admin.php") ?>
                                                <?php endforeach; ?>
                                            <?php } else { ?>
                                                <div class="alert alert-warning ms-4">El alumno no tiene fichas</div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (rol($_SESSION["user_id"]) === 3): ?>
                    <div class="w-100">
                        <div class="d-flex justify-content-start div-crear">
                            <div class="me-3">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-crear">Crear ficha semanal</button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row w-100 mt-3">
                        <div class="d-flex flex-wrap m-2" id="div-fichas">
                            <?php foreach (get_fichas($_SESSION["user_id"]) as $ficha): ?>
                                <div class="ms-4 mb-4 card">
                                    <div class="card-header d-flex justify-content-between">Semana: <?= $ficha["semana"] ?><span class="trash-ficha"><i class="fa-solid fa-trash-can"></i></span></div>
                                    <div class="card-body d-flex flex-column">
                                        <p class="card-text">Fecha: <?= fecha_normal($ficha["fecha"]) ?></p>
                                        <p class="card-text">Horas: <?= get_horas_semana($ficha["id_ficha"]) ?> / 40</p>
                                        <div class="d-flex flex-row justify-content-end mt-5">
                                            <button type="button" class="btn w-25 btn-success btn-imprimir me-2 mt-2"><i class="fa-solid fa-print"></i></button>
                                            <input type="hidden" class="f-id" value="<?= $ficha["id_ficha"] ?>">
                                            <button type="button" class="btn w-25 btn-primary edit-ficha mt-2" data-bs-toggle="modal" data-bs-target="#modal-editar"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Modal crear -->
                    <div class="modal fade" id="modal-crear" tabindex="-1" aria-labelledby="modalCrear" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5 text-black" id="modalCrear">Crear ficha semanal</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <form id="form-create" method="POST">
                                            <label class="form-label text-black" for="fecha">Semana del:</label>
                                            <input class="form-control" type="date" name="inp-fecha" id="fecha" onkeydown="return false;">
                                            <br>
                                            <label class="form-label text-black" for="fecha">Semana número:</label>
                                            <input class="form-control w-25" type="number" name="inp-semana" min="1" id="num_semana">
                                            <br>
                                            <button type="button" class="btn btn-success" id="btn-create">Crear</button>
                                        </form>
                                    </div>
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
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <?php include_once($dir . "/cms/includes/footer.php") ?>
    </footer>

    <?php if (rol($_SESSION["user_id"]) === 1): ?>
        <script>
            $(document).on("click", ".btn-imprimir-admin", function() {
                let $id = $(this).closest(".card").find(".f-id").val();
                let $idAlumno = $(this).closest(".card").find(".a-id").val();
                const url = `/cms/includes/generar_ficha_admin.php?ai=${$idAlumno}&fi=${$id}`;
                window.open(url, "_blank");
            });
        </script>
    <?php endif; ?>
</body>

</html>