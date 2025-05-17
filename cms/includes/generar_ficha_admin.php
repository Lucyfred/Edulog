<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

require_once($dir . "/includes/general.php");
require_once($dir . "/cms/includes/checkeo_admin.php");
require_once($dir . "/vendor/autoload.php");
include_once($dir . "/cms/includes/showErrors.php");


use setasign\Fpdi\Fpdi;

if($_SERVER["REQUEST_METHOD"] === "GET"){
    global $conn;
    $id_alumno = $_GET["ai"];
    $id_ficha = $_GET["fi"];
    $alumno = get_student_data($id_alumno);

    $query = "SELECT *,
    a.id_dia as dia
    FROM ficha f
    INNER JOIN actividades a ON a.id_ficha = f.id_ficha
    WHERE f.id_alumno = ?
    AND a.id_ficha = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_alumno, $id_ficha);
    $stmt->execute();
    $result = $stmt->get_result();
    $datos = [];

    while($dato = $result->fetch_assoc()){
        $datos[] = $dato;
    }

    if(count($datos) == 0){
        header("LOCATION: /cms/includes/404.html");
    }

    $stmt->close();

    $fecha_inicio_st = $datos[0]["fecha"];
    $fecha_inicio = date("y-m-d", strtotime($fecha_inicio_st . " +0 days"));
    $fecha_fin = date("Y-m-d", strtotime($fecha_inicio . " +5 days"));
    
    $fecha_partes = explode("-", $fecha_inicio);
    $fecha_dia = $fecha_partes[2];
    $fecha_mes = $fecha_partes[1];
    $fecha_ano = $fecha_partes[0];

    $fecha_fin_partes = explode("-", $fecha_fin);
    $fecha_fin_dia = $fecha_fin_partes[2];

    switch($fecha_mes){
        case 1:
            $mes = "enero";
            break;
        case 2:
            $mes = "febrero";
            break;
        case 3:
            $mes = "marzo";
            break;
        case 4:
            $mes = "abril";
            break;
        case 5:
            $mes = "mayo";
            break;
        case 6:
            $mes = "junio";
            break;
        case 7:
            $mes = "julio";
            break;
        case 8:
            $mes = "agosto";
            break;
        case 9:
            $mes = "septiembre";
            break;
        case 10:
            $mes = "octubre";
            break;
        case 11:
            $mes = "noviembre";
            break;
        case 12:
            $mes = "diciembre";
            break;
        default:
            $mes = "NULL";
            break;
    }
    
    $pdf = new Fpdi();
    $pdf->AddPage("horizontal");
    $pdf->SetSourceFile($dir . "/cms/uploads/default/ficha/fichasemanal.pdf");
    $templateId = $pdf->importPage(1);
    $pdf->useTemplate($templateId);
    
    $pdf->SetFont("Arial", "", 9);
    // Posición del dia de inicio
    $pdf->SetXY(55, 35.5);
    $pdf->Write(0, $fecha_dia);
    // Posición del dia fin
    $pdf->SetXY(70, 35.5);
    $pdf->Write(0, $fecha_fin_dia);
    // Posición del mes
    $pdf->SetXY(84, 35.5);
    $pdf->Write(0, $mes);
    // Posición del ano
    $pdf->SetXY(119, 35.5);
    $pdf->Write(0, $fecha_ano);
    // Posición del centro docente
    $pdf->SetXY(62, 43);
    $pdf->Write(0, ($alumno["centro"]) ? (mb_convert_encoding($alumno["centro"], 'ISO-8859-1', 'UTF-8')) : "");
    // Posición del tutor centro
    $pdf->SetXY(96.5, 48.5);
    $pdf->Write(0, ($alumno["tutor_c"]) ? (mb_convert_encoding($alumno["tutor_c"], 'ISO-8859-1', 'UTF-8')) : "");
    // Posición del centro de trabajo
    $pdf->SetXY(191, 43);
    $pdf->Write(0, ($alumno["empresa"]) ? (mb_convert_encoding($alumno["empresa"], 'ISO-8859-1', 'UTF-8')) : "");
    // Posición del centro de trabajo
    $pdf->SetXY(197, 48.8);
    $pdf->Write(0, ($alumno["tutor_e"]) ? (mb_convert_encoding($alumno["tutor_e"], 'ISO-8859-1', 'UTF-8')) : "");
    // Posición del nombre
    $pdf->SetXY(62, 56);
    $pdf->Write(0, ($alumno["nombre"]) ? (mb_convert_encoding($alumno["nombre"], 'ISO-8859-1', 'UTF-8')) : "");
    // Posición del ciclo
    $pdf->SetXY(170.5, 56);
    $pdf->Write(0, ($alumno["fp"]) ? (mb_convert_encoding($alumno["fp"], 'ISO-8859-1', 'UTF-8')) : "");
    // Posición del grado
    $pdf->SetXY(242.5, 56);
    $pdf->Write(0, ($alumno["grado"]) ? (mb_convert_encoding($alumno["grado"], 'ISO-8859-1', 'UTF-8')) : "");
    // Posición de la actividad del lunes
    $pdf->SetXY(56, 72);
    $pdf->MultiCell(133, 5, ($datos[0]["actividad"]) ? (mb_convert_encoding($datos[0]["actividad"], 'ISO-8859-1', 'UTF-8')) : "", 0, "L");
    // Posición de las horas del lunes
    $pdf->SetXY(188, 72);
    $pdf->MultiCell(133, 5, ($datos[0]["horas"]) ? $datos[0]["horas"] . " horas" : "", 0, "L");
    // Posición de la actividad del martes
    $pdf->SetXY(56, 90);
    $pdf->MultiCell(133, 5, ($datos[1]["actividad"]) ? (mb_convert_encoding($datos[1]["actividad"], 'ISO-8859-1', 'UTF-8')) : "", 0, "L");
    // Posición de las horas del martes
    $pdf->SetXY(188, 90);
    $pdf->MultiCell(133, 5, ($datos[1]["horas"]) ? $datos[1]["horas"] . " horas" : "", 0, "L");
    // Posición de la actividad del miercoles
    $pdf->SetXY(56, 108);
    $pdf->MultiCell(133, 5, ($datos[2]["actividad"]) ? (mb_convert_encoding($datos[2]["actividad"], 'ISO-8859-1', 'UTF-8')) : "", 0, "L");
    // Posición de las horas del miercoles
    $pdf->SetXY(188, 108);
    $pdf->MultiCell(133, 5, ($datos[2]["horas"]) ? $datos[2]["horas"] . " horas" : "", 0, "L");
    // Posición de la actividad del jueves
    $pdf->SetXY(56, 126);
    $pdf->MultiCell(133, 5, ($datos[3]["actividad"]) ? (mb_convert_encoding($datos[3]["actividad"], 'ISO-8859-1', 'UTF-8')) : "", 0, "L");
    // Posición de las horas del jueves
    $pdf->SetXY(188, 126);
    $pdf->MultiCell(133, 5, ($datos[3]["horas"]) ? $datos[3]["horas"] . " horas" : "", 0, "L");
    // Posición de la actividad del viernes
    $pdf->SetXY(56, 144);
    $pdf->MultiCell(133, 5, ($datos[4]["actividad"]) ? (mb_convert_encoding($datos[4]["actividad"], 'ISO-8859-1', 'UTF-8')) : "", 0, "L");
    // Posición de las horas del viernes
    $pdf->SetXY(188, 144);
    $pdf->MultiCell(133, 5, ($datos[4]["horas"]) ? $datos[4]["horas"] . " horas" : "", 0, "L");
    
    
    
    $pdf->Output();
}
