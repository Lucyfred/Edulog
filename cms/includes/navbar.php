<?php

$logOut = $url_site . "/login";

echo <<<HTML

    <div class="navbar main-navbar d-flex">
        <div class="bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand logo-md text-white" href="{$url_site}">Edulog</a>
            </div>
        </div>
        <div class="me-5">
            <!-- <a href="" class="menu_user"><i class="bi bi-person"></i></a> -->
            <div class="dropdown">
                <a class="menu_user" id="dropdownMenuUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuUser">
                    <li><a class="dropdown-item" href="{$logOut}">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </div>

HTML;