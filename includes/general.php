<?php

$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$dominio = $_SERVER['HTTP_HOST'];

$url_site = $protocolo . "://" . $dominio;