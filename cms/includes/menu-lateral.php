<?php

// Menú lateral el cual recoge la información de la URL para dejar activa la opción

$url = $_SERVER['REQUEST_URI'];

$activoHome = ($url == '/index') ? 'activo' : '';
$activoFichas = ($url == '/fichas') ? 'activo' : '';
$activoUsuarios = ($url == '/usuarios') ? 'activo' : '';
$activoUsuariosSR = ($url == '/usuariosSR') ? 'activo' : '';
$activoUsuariosNR = ($url == '/usuariosNR') ? 'activo' : '';
$activoAjustes = ($url == '/ajustes') ? 'activo' : '';
$subMenu = ($url == '/usuariosSR' || $url == '/usuariosNR') ? '' : 'd-none';

echo <<<HTML
    <div class="main-menu">
        <div class="d-flex flex-column">
            <a class="unst" href="{$url_site}/index" id="home"><div class="d-flex align-items-center menu-option {$activoHome}"><i class="bi bi-house ms-4"></i><span class="ms-4">Inicio</span></div></a>
            <a class="unst" href="{$url_site}/fichas" id="files"><div class="d-flex align-items-center menu-option {$activoFichas}"><i class="bi bi-file-earmark-text ms-4"></i><span class="ms-4">Fichas</span></div></a>
HTML;
if(rol($_SESSION["user_id"]) === 1){
    echo <<<HTML
    <a class="unst" href="{$url_site}/usuarios" id="usuarios"><div class="d-flex align-items-center menu-option"><i class="fa-solid fa-user ms-4"></i><span class="ms-4">Usuarios</span></div></a>
    <div id="menu-usuarios" class="{$subMenu}">
        <a class="unst" href="{$url_site}/usuariosSR" id="usuarios-registrados"><div class="d-flex align-items-center menu-option-secundary {$activoUsuariosSR}"><i class="fa-solid fa-user-plus ms-4"></i><span class="ms-4">Iniciados</span></div></a>
        <a class="unst" href="{$url_site}/usuariosNR" id="usuarios-sinregistrar"><div class="d-flex align-items-center menu-option-secundary {$activoUsuariosNR}"><i class="fa-solid fa-user-minus ms-4"></i><span class="ms-4">Sin iniciar</span></div></a>
    </div>
HTML;
}
echo <<<HTML
            <a class="unst" href="{$url_site}/ajustes" id="settings"><div class="d-flex align-items-center menu-option {$activoAjustes}"><i class="bi bi-file-earmark-text ms-4"></i><span class="ms-4">Ajustes</span></div></a>
        </div>
    </div>
HTML;
