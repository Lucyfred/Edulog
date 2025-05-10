<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");

if (!isLogged()) {
    header("LOCATION: login");
}

if (first_login($_SESSION["user_id"]) !== 0) {
    header("LOCATION: index");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include_once($dir . "/cms/includes/head.php") ?>
</head>

<body>
    <div class="container position-relative d-flex align-items-center justify-content-center fullScreen">
        <div class="row div-circles">
            <div class="position-absolute start-50 translate-middle z-index-overlay" id="div-form-datos">
                <div id="div-form">
                    <h1 class="text-center">Bienvenid@ a Edulog</h1>
                    <br>
                    <form id="form-datos" method="POST">
                        <label class="form-label" for="nombre">Nombre:</label>
                        <input type="text" class="form-control mb-3" name="inp-nombre" id="nombre">
                        <label class="form-label" for="apellidos">Apellidos:</label>
                        <input type="text" class="form-control mb-3" name="inp-apellidos" id="apellidos">
                        <label class="form-label" for="fp">Ciclo formativo:</label>
                        <input type="text" class="form-control mb-3" name="inp-fp" id="fp">
                        <label class="form-label" for="grado">Grado:</label>
                        <select class="form-control mb-3" name="inp-grado" id="grado">
                            <option value="" selected disabled>Elija un grado</option>
                            <option value="1">Grado medio</option>
                            <option value="2">Grado superior</option>
                        </select>
                        <label class="form-label" for="nombre-esc">Nombre del centro:</label>
                        <input type="text" class="form-control mb-3" name="inp-nombre-esc" id="nombre-esc">
                        <label class="form-label" for="tutor-esc">Nombre del tutor escolar:</label>
                        <input type="text" class="form-control mb-3" name="inp-tutor-esc" id="tutor-esc">
                        <label class="form-label" for="nombre-lab">Nombre de la empresa:</label>
                        <input type="text" class="form-control mb-3" name="inp-nombre-lab" id="nombre-lab">
                        <label class="form-label" for="tutor-lab">Nombre del tutor laboral:</label>
                        <input type="text" class="form-control mb-3" name="inp-tutor-lab" id="tutor-lab">
                        <label class="form-label" for="pass">Contraseña:</label>
                        <input type="password" class="form-control mb-3" name="inp-pass" id="pass">
                        <label class="form-label" for="pass2">Confirmar contraseña:</label>
                        <input type="password" class="form-control mb-4" name="inp-pass2" id="pass2">
                    </form>
                    <input type="button" class="form-control mainBoton" name="submit" id="submitDatos" value="Enviar">
                </div>
            </div>
            <div class="col d-flex justify-content-center align-items-center position-relative opacityDiv">
                <div class="col-4 d-flex justify-content-center align-items-center position-relative purpleDiv">
                    <div class="position-absolute purpleCircle" id="purpleCircle"></div>
                </div>
                <div class="col-4 d-flex justify-content-center align-items-center position-relative blueDiv">
                    <div class="position-absolute blueCircle" id="blueCircle"></div>
                </div>
                <div class="col-4 d-flex justify-content-center align-items-center position-relative redDiv">
                    <div class="position-absolute redCircle" id="redCircle"></div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <?php include_once($dir . "/cms/includes/footer.php") ?>
    </footer>
    <script>
        window.onload = () => {
            document.getElementById("nombre").focus();
        };

        $(document).ready(function(){
            $("#submitDatos").click( function(e){
                let $nombre = $("#nombre").val();
                let $apellidos = $("#apellidos").val();
                let $fp = $("#fp").val();
                let $grado = $("#grado").val();
                let $nombre_esc = $("#nombre-esc").val();
                let $tutor_esc = $("#tutor-esc").val();
                let $nombre_lab = $("#nombre-lab").val();
                let $tutor_lab = $("#tutor-lab").val();
                let $pass = $("#pass").val();
                let $pass2 = $("#pass2").val();

                if($nombre.length == 0){
                    e.preventDefault();
                    Swal.fire({
                        icon: "error",
                        title: "Campos incompletos",
                        text: "Por favor rellene el campo nombre",
                    });
                    return;
                }
                if($apellidos.length == 0){
                    e.preventDefault();
                    Swal.fire({
                        icon: "error",
                        title: "Campos incompletos",
                        text: "Por favor rellene el campo apellidos",
                    });
                    return;
                }
                if($fp.length == 0){
                    e.preventDefault();
                    Swal.fire({
                        icon: "error",
                        title: "Campos incompletos",
                        text: "Por favor rellene el campo ciclo formativo",
                    });
                    return;
                }
                if($grado == "" || $grado == null){
                    e.preventDefault();
                    Swal.fire({
                        icon: "error",
                        title: "Campos incompletos",
                        text: "Por favor rellene el campo grado",
                    });
                    return;
                }
                if($nombre_esc.length == 0){
                    e.preventDefault();
                    Swal.fire({
                        icon: "error",
                        title: "Campos incompletos",
                        text: "Por favor rellene el campo nombre del centro",
                    });
                    return;
                }
                if($tutor_esc.length == 0){
                    e.preventDefault();
                    Swal.fire({
                        icon: "error",
                        title: "Campos incompletos",
                        text: "Por favor rellene el campo nombre del tutor escolar",
                    });
                    return;
                }
                if($nombre_lab.length == 0){
                    e.preventDefault();
                    Swal.fire({
                        icon: "error",
                        title: "Campos incompletos",
                        text: "Por favor rellene el campo nombre de la empresa",
                    });
                    return;
                }
                if($tutor_lab.length == 0){
                    e.preventDefault();
                    Swal.fire({
                        icon: "error",
                        title: "Campos incompletos",
                        text: "Por favor rellene el campo nombre del tutor laboral",
                    });
                    return;
                }
                if($pass.length == 0){
                    e.preventDefault();
                    Swal.fire({
                        icon: "error",
                        title: "Campos incompletos",
                        text: "Por favor rellene el campo contraseña",
                    });
                    return;
                }
                if($pass2.length == 0){
                    e.preventDefault();
                    Swal.fire({
                        icon: "error",
                        title: "Campos incompletos",
                        text: "Por favor rellene el campo confirmar contraseña",
                    });
                    return;
                }
                if($pass !== $pass2){
                    e.preventDefault();
                    Swal.fire({
                        icon: "error",
                        title: "Contraseñas diferentes",
                        text: "La contraseña es diferente a la confirmada",
                    });
                    return;
                }

                $.ajax({
                    url: "<?= $url_site ?>" + "/cms/includes/update_datos.php",
                    method: "POST",
                    data: $("#form-datos").serialize(),
                    success: function(res){
                        if(res.success == "false"){
                            $("#alert").remove();
                            $("#div-form").append(`<div class="alert alert-danger mt-4" id="alert">${res.message}</div>`);
                        } else if(res.success = "true"){
                            window.location.href = res.redirect;
                        }
                    }
                })
            })
        })
    </script>
</body>

</html>