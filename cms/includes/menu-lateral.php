<?php

$url = $_SERVER['REQUEST_URI'];

$activoHome = ($url == '/index') ? 'activo' : '';
$activoFichas = ($url == '/fichas') ? 'activo' : '';
$activoPlantillas = ($url == '/plantillas') ? 'activo' : '';
$activoAjustes = ($url == '/ajustes') ? 'activo' : '';

echo <<<HTML
    <div class="main-menu">
        <div class="d-flex flex-column">
            <a class="unst" href="{$url_site}/index" id="home"><div class="d-flex align-items-center menu-option {$activoHome}"><i class="bi bi-house ms-4"></i><span class="ms-4">Inicio</span></div></a>
            <a class="unst" href="{$url_site}/fichas" id="files"><div class="d-flex align-items-center menu-option {$activoFichas}"><i class="bi bi-file-earmark-text ms-4"></i><span class="ms-4">Fichas</span></div></a>
            <a class="unst" id="templates"><div class="d-flex align-items-center menu-option {$activoPlantillas}"><i class="bi bi-file-earmark-font ms-4"></i><span class="ms-4">Plantillas</span></div></a>
            <a class="unst" href="{$url_site}/ajustes" id="settings"><div class="d-flex align-items-center menu-option {$activoAjustes}"><i class="bi bi-file-earmark-text ms-4"></i><span class="ms-4">Ajustes</span></div></a>
        </div>
    </div>
HTML;
