<?php

$logOut = $url_site . "/login";

echo <<<HTML

    <div class="navbar main-navbar d-flex">
        <div class="bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand logo-md text-white" href="{$url_site}/index">Edulog</a>
            </div>
        </div>
        <div class="me-5">
            <div class="dropdown">
                <a class="menu_user" id="dropdownMenuUser" data-bs-toggle="dropdown" aria-expanded="false">
HTML;

if(check_avatar($_SESSION["user_id"]) == true){
    echo '<img src="' . $url_site . '/cms/assets/img/avatar/' . user_info($_SESSION["user_id"])["avatar"] . '" class="rounded-circle shadow avatar-sm" alt="avatar" onerror="this.style.display=\'none\'; this.nextElementSibling.style.display=\'inline-block\';">';
} else{
    echo '<i class="bi bi-person"></i>';
}

echo <<<HTML
                <i class="bi bi-person" style="display:none;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuUser">
                    <li><a class="dropdown-item" href="{$logOut}">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </div>

HTML;