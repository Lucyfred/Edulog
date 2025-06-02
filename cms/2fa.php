<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");
include_once($dir . "/cms/includes/checkeo.php");
include_once($dir . "/cms/includes/showErrors.php");

// Sin implementar, doble autenticación, si el usuario lo tiene activo
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include_once($dir . "/cms/includes/head.php") ?>
</head>

<body>
    <div class="container" style="width: 100vw; height: 100vh;">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div id="div-content">
                <h3>Autenticación de dos factores</h3>
                <p>Por favor, introduce el código de autenticación de dos factores para continuar.</p>
                <form method="POST" action="verify_2fa.php">
                    <div class="mb-3">
                        <label for="code" class="form-label">Código de autenticación</label>
                        <input type="text" class="form-control" id="code" name="code" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Verificar</button>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <?php include_once($dir . "/cms/includes/footer.php") ?>
    </footer>
</body>

</html>