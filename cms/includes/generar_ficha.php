<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$dir = $_SERVER["DOCUMENT_ROOT"];

require_once($dir . "/includes/general.php");
require_once($dir . '/vendor/autoload.php');

use setasign\Fpdi\Fpdi;

$alumno = get_student_data($_SESSION["user_id"]);

$pdf = new Fpdi();
$pdf->AddPage("horizontal");
$pdf->SetSourceFile($dir . "/cms/uploads/default/ficha/fichasemanal.pdf");
$templateId = $pdf->importPage(1);
$pdf->useTemplate($templateId);

$pdf->SetFont("Arial", "", 9);
// Posición del centro docente
$pdf->SetXY(62, 43);
$pdf->Write(0, $alumno["centro"]);
// Posición del tutor centro
$pdf->SetXY(96.5, 48.5);
$pdf->Write(0, $alumno["tutor_c"]);
// Posición del centro de trabajo
$pdf->SetXY(191, 43);
$pdf->Write(0, $alumno["empresa"]);
// Posición del centro de trabajo
$pdf->SetXY(197, 48.8);
$pdf->Write(0, $alumno["tutor_e"]);
// Posición del nombre
$pdf->SetXY(62, 56);
$pdf->Write(0, $alumno["nombre"]);



$pdf->Output();