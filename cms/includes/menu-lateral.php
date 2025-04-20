<?php

$url = $_SERVER['REQUEST_URI'];

$activoHome = ($url == '/index.php') ? 'activo' : '';
$activoFichas = ($url == '/fichas.php') ? 'activo' : '';
$activoPlantillas = ($url == '/plantillas.php') ? 'activo' : '';
$activoAjustes = ($url == '/ajustes.php') ? 'activo' : '';

echo <<<HTML
    <div class="main-menu">
        <div class="d-flex flex-column">
            <a class="unst" href="{$url_site}/index.php" id="home"><div class="d-flex align-items-center menu-option {$activoHome}"><i class="bi bi-house ms-4"></i><span class="ms-4">Inicio</span></div></a>
            <a class="unst" href="{$url_site}/fichas.php" id="files"><div class="d-flex align-items-center menu-option {$activoFichas}"><i class="bi bi-file-earmark-text ms-4"></i><span class="ms-4">Fichas</span></div></a>
            <a class="unst" id="templates"><div class="d-flex align-items-center menu-option {$activoPlantillas}"><i class="bi bi-file-earmark-font ms-4"></i><span class="ms-4">Plantillas</span></div></a>
            <a class="unst" id="settings"><div class="d-flex align-items-center menu-option {$activoAjustes}"><i class="bi bi-file-earmark-text ms-4"></i><span class="ms-4">Ajustes</span></div></a>
        </div>
    </div>
HTML;
