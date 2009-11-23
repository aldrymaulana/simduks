<?php
require_once "../../tcpdf/config/lang/eng.php";
require_once "../../tcpdf/tcpdf.php";
include_once "../../includes/helpers.inc.php";

$pdf = new TCPDF("P", PDF_UNIT, "A6", true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(4, 5, 4);
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false);
$pdf->SetTitle("kartu pernikahan");
$pdf->SetAutoPageBreak(TRUE, 4);
// image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// language-dependent strings
$pdf->setLanguageArray($l);

$pdf->AddPage();

$pdf->SetFont("times",'', 12);
$pdf->MultiCell(100,1, "KUTIPAN AKTA NIKAH",0, 'C',0,1);
$pdf->Cell(20, 1, "Nomor",0, 0,'L',0);
$pdf->MultiCell(55,1, "14626VII2006",0,'L',0,1);

$pdf->Output("pernikahan.pdf","I");
?>