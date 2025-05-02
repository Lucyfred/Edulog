<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/security.php");

logOut();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include_once($dir . "/cms/includes/head.php") ?>
</head>

<body>
    <div class="container position-relative d-flex align-items-center justify-content-center fullScreen" id="mainDiv">
        <div class="position-absolute divLogo pb">
            <div class="text-center logo">
                <p class="user-select-none">Edulog</p>
            </div>
        </div>
        <div class="row div-circles">
            <div class="position-absolute top-50 start-50 translate-middle z-index-overlay" id="divForm">
                <div class="text-center">
                    <h2>Iniciar sesión</h2>
                    <p class="mb-4">Introduce el email y contraseña <br> para iniciar sesión en Edulog</p>
                    <form id="loginForm" method="POST">
                        <input type="email" class="form-control mb-3" name="email" id="email" placeholder="email@dominio.com">
                        <input type="password" class="form-control mb-3" name="pass" id="pass" placeholder="contraseña">
                        <input type="submit" class="form-control mainBoton mb-4" name="submit" id="submitLogin" value="Iniciar sesión">
                        <p>¿Has olvidado la contraseña?</p>
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
</body>

</html>