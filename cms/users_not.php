<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");
include_once($dir . "/cms/includes/checkeo.php");
include_once($dir . "/cms/includes/checkeo_admin.php");

$usuarios = get_all_users_nr();
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
                <div class="w-100 mb-4">
                    <div class="d-flex justify-content-start">
                        <div class="me-3">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-crear-usuario">Crear usuario</button>
                        </div>
                    </div>
                </div>
                <table class="table text-white table-striped table-dark table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Email</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Contraseña</th>
                            <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <?php if (!empty($usuarios)) { ?>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td class="col"><?= $usuario["email"] ?></td>
                                    <td class="col user-data">
                                        <input type="hidden" name="id" class="id_user" value="<?= $usuario["id_usuario"] ?>">
                                        <select name="rol" class="form-select id_rol w-50">
                                            <option value="<?= ($usuario["rol_id"]) ? $usuario["rol_id"] : "" ?>" selected disabled><?= ($usuario["nombre_rol"]) ? ucfirst($usuario["nombre_rol"]) : "Elija un rol" ?></option>
                                            <?php foreach (get_all_rols() as $rol): ?>
                                                <option value="<?= $rol["id_rol"] ?>"><?= ucfirst($rol["nombre"]) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td class="col">
                                        <button type="button" class="btn btn-warning btn-change-pass" data-bs-toggle="modal" data-bs-target="#modal-editar-pass">Cambiar</button>
                                    </td>
                                    <td class="col">
                                        <button type="button" class="btn btn-danger btn-remove-user"><i class="fa-solid fa-trash-can"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php } else { ?>
                            <tr>
                                <td class="text-center" colspan="4">
                                    <div class="alert alert-warning">No se encontraron registros</div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal editar contraseña -->
    <div class="modal fade" id="modal-editar-pass" tabindex="-1" aria-labelledby="modalEditPass" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-black" id="modalEditPass">Cambiar contraseña</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <form id="form-edit-pass" method="POST">
                            <label class="form-label text-black" for="pass">Usuario: </label>
                            <br>
                            <label class="form-label text-black" for="pass">Contraseña:</label>
                            <input class="form-control" type="password" name="inp-pass" id="pass">
                            <br>
                            <label class="form-label text-black" for="pass2">Confirmar contraseña:</label>
                            <input class="form-control" type="password" name="inp-pass2" id="pass2">
                            <br>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success btn-success-pass" id="btn-edit-pass">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal crear usuario -->
    <div class="modal fade" id="modal-crear-usuario" tabindex="-1" aria-labelledby="modalCrearUsuario" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-black" id="modalCrearUsuario">Crear usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <form id="form-crear-usuario" method="POST">
                            <div class="row mb-3">
                                <div class="col-9">
                                    <label class="form-label text-black" for="fecha">Email</label>
                                    <input class="form-control" name="email-usuario" id="email"></input>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-9">
                                    <label class="form-label text-black" for="rol">Rol</label>
                                    <select name="rol-usuario" class="form-select" id="rol_usuario">
                                        <option value="" selected disabled>Elija un rol</option>
                                        <?php foreach (get_all_rols() as $rol): ?>
                                            <option value="<?= $rol["id_rol"] ?>"><?= ucfirst($rol["nombre"]) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-9">
                                    <label class="form-label text-black" for="fecha">Contraseña</label>
                                    <input type="password" class="form-control" name="pass-usuario" id="password-usuario"></input>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-9">
                                    <label class="form-label text-black" for="fecha">Confirmar contraseña</label>
                                    <input type="password" class="form-control" name="pass2-usuario" id="password2-usuario"></input>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" id="btn-save-usuario">Guardar</button>
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
        $(document).ready(function() {
            $(".id_rol").on("change", function() {
                let $idUser = $(this).prev().val();
                let $idRol = $(this).val();

                if ($idUser <= 0 || $idRol <= 0) {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: "Ocurrió un error al intentar editar el rol",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    return;
                }

                $.ajax({
                    url: "/cms/includes/func/edit_rol.php",
                    method: "POST",
                    data: {
                        idUser: $idUser,
                        idRol: $idRol
                    },
                    success: function(res) {
                        if (res.code === "200") {
                            sessionStorage.setItem("swalMessage", res.message);
                            sessionStorage.setItem("swalType", "success");
                            location.reload();
                        }
                    }
                })
            })
        })

        $(document).ready(function() {
            $("#modal-editar-pass").on("shown.bs.modal", function() {
                $("#pass").focus();
            })

            $("#pass").on("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    $("#pass2").focus();
                }
            })

            $("#pass2").on("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    $("#btn-edit-pass").focus().click();
                }
            })

            $(".btn-change-pass").on("click", function() {
                let $idUser = $(this).closest("tr").find(".id_user").val();
                $("#form-edit-pass").append(`<input type="hidden" id="id_user" value="${$idUser}">`)
            })

            $(".btn-success-pass").on("click", function() {
                let $idUser = $(this).closest("#form-edit-pass").find("#id_user").val();
                let $pass = $("#pass").val();
                let $pass2 = $("#pass2").val();

                if ($idUser <= 0) {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: "Ocurrió un error al intentar editar el rol",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    return;
                }

                if ($pass !== $pass2) {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: "Las contraseñas no coinciden",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    return;
                }

                if ($pass == "" || $pass2 == "") {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: "Los campos contraseña no pueden estar vacíos",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    return;
                }

                $.ajax({
                    url: "/cms/includes/func/edit_pass_admin.php",
                    method: "POST",
                    data: {
                        idUser: $idUser,
                        pass: $pass
                    },
                    success: function(res) {
                        if (res.code === "200") {
                            sessionStorage.setItem("swalMessage", res.message);
                            sessionStorage.setItem("swalType", "success");
                            location.reload();
                        } else {
                            Swal.fire({
                                toast: true,
                                position: "top-end",
                                icon: "error",
                                title: res.message,
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        }
                    }
                })
            })
        })

        $(".btn-remove-user").on("click", function() {
            let $idUser = $(this).closest("tr").find(".id_user").val();

            if ($idUser <= 0) {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: "Ocurrió un error al intentar editar el rol",
                    showConfirmButton: false,
                    timer: 3000,
                });
                return;
            }

            let confirmacion = confirm("¿Seguro que quieres eliminar al usuario?");

            if (confirmacion) {
                $.ajax({
                    url: "/cms/includes/func/borrar_usuario_admin.php",
                    method: "POST",
                    data: {
                        idUser: $idUser
                    },
                    success: function(res) {
                        if (res.code === "200") {
                            sessionStorage.setItem("swalMessage", res.message);
                            sessionStorage.setItem("swalType", "success");
                            location.reload();
                        } else {
                            Swal.fire({
                                toast: true,
                                position: "top-end",
                                icon: "error",
                                title: res.message,
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        }
                    }
                })
            }
        })

        $("#btn-save-usuario").on("click", function() {
            let $email = $("#email").val();
            let $rol = $("#rol_usuario").val();
            let $pass = $("#password-usuario").val();
            let $pass2 = $("#password2-usuario").val();

            if ($email == "") {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: "Por favor rellene el campo email",
                    showConfirmButton: false,
                    timer: 3000,
                });
                return;
            }

            if (!emailCheck($email)) {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: "Email no válido",
                    showConfirmButton: false,
                    timer: 3000,
                });
                return;
            }

            if (!$rol) {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: "Por favor rellene el campo rol",
                    showConfirmButton: false,
                    timer: 3000,
                });
                return;
            }

            if ($pass == "") {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: "Por favor rellene el campo contraseña",
                    showConfirmButton: false,
                    timer: 3000,
                });
                return;
            }

            if ($pass2 == "") {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: "Por favor rellene el campo confirmar contraseña",
                    showConfirmButton: false,
                    timer: 3000,
                });
                return;
            }

            if ($pass !== $pass2) {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: "Las contraseñas no coinciden",
                    showConfirmButton: false,
                    timer: 3000,
                });
                return;
            }


            $.ajax({
                url: "/cms/includes/func/crear_usuario_admin.php",
                method: "POST",
                data: $("#form-crear-usuario").serialize(),
                success: function(res) {
                    if (res.code === "200") {
                        sessionStorage.setItem("swalMessage", res.message);
                        sessionStorage.setItem("swalType", "success");
                        location.reload();
                    } else {
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "error",
                            title: res.message,
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    }
                }
            })

        })

        $("#modal-editar-pass").on("hidden.bs.modal", function() {
            $(this).find("#form-edit-pass")[0].reset();
            $(this).find("#id_user").remove();
        })

        $("#modal-crear-usuario").on("hidden.bs.modal", function() {
            $(this).find("#form-crear-usuario")[0].reset();
        })
    </script>

</body>

</html>