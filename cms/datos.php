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
                <div>
                    <h1 class="text-center">Bienvenid@ a Edulog</h1>
                    <br>
                    <form id="form-datos" method="POST" action="<?= $url_site ?>/cms/includes/update_datos.php">
                        <label class="form-label" for="nombre">Nombre:</label>
                        <input type="text" class="form-control mb-3" name="inp-nombre" id="nombre" required>
                        <label class="form-label" for="apellidos">Apellidos:</label>
                        <input type="text" class="form-control mb-3" name="inp-apellidos" id="apellidos" required>
                        <label class="form-label" for="fp">Ciclo formativo:</label>
                        <input type="text" class="form-control mb-3" name="inp-fp" id="fp" required>
                        <label class="form-label" for="grado">Grado:</label>
                        <select class="form-control mb-3" name="inp-grado" id="grado" required>
                            <option value="" selected disabled>Elija un grado</option>
                            <option value="1">Grado medio</option>
                            <option value="2">Grado superior</option>
                        </select>
                        <label class="form-label" for="nombre-esc">Nombre del centro:</label>
                        <input type="text" class="form-control mb-3" name="inp-nombre-esc" id="nombre-esc" required>
                        <label class="form-label" for="tutor-esc">Nombre del tutor escolar:</label>
                        <input type="text" class="form-control mb-3" name="inp-tutor-esc" id="tutor-esc" required>
                        <label class="form-label" for="nombre-lab">Nombre de la empresa:</label>
                        <input type="text" class="form-control mb-3" name="inp-nombre-lab" id="nombre-lab" required>
                        <label class="form-label" for="tutor-lab">Nombre del tutor laboral:</label>
                        <input type="text" class="form-control mb-3" name="inp-tutor-lab" id="tutor-lab" required>
                        <label class="form-label" for="pass">Contraseña:</label>
                        <input type="password" class="form-control mb-3" name="inp-pass" id="pass" required>
                        <label class="form-label" for="pass2">Confirmar contraseña:</label>
                        <input type="password" class="form-control mb-4" name="inp-pass2" id="pass2" required>
                        <input type="submit" class="form-control mainBoton" name="submit" id="submitDatos">
                    </form>
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
    </script>
</body>

</html>