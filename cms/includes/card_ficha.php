<?php

// Genera una card con la ficha del usuario con la opción de imprimirla, editarla o eliminarla

$semana = $ficha["semana"];
$fecha = fecha_normal($ficha["fecha"]);
$horas = get_horas_semana($ficha["id_ficha"]);
$id_ficha = $ficha["id_ficha"];

echo <<<HTML
    <div class="ms-4 mb-4 card">
        <div class="card-header d-flex justify-content-between">Semana: {$semana}<span class="trash-ficha"><i class="fa-solid fa-trash-can"></i></span></div>
        <div class="card-body d-flex flex-column">
            <p class="card-text">Fecha: {$fecha}</p>
            <p class="card-text">Horas: {$horas} / 40</p>
            <div class="d-flex flex-row justify-content-end mt-5">
                <button type="button" class="btn w-25 btn-success btn-imprimir me-2 mt-2"><i class="fa-solid fa-print"></i></button>
                <input type="hidden" class="f-id" value="{$id_ficha}">
                <button type="button" class="btn w-25 btn-primary edit-ficha mt-2" data-bs-toggle="modal" data-bs-target="#modal-editar"><i class="fa-solid fa-pen-to-square"></i></button>
            </div>
        </div>
    </div>
HTML;
