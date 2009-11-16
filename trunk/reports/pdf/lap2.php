<?php
require_once "../../tcpdf/config/lang/eng.php";
require_once "../../tcpdf/tcpdf.php";
include_once "../../includes/helpers.inc.php";



$pdf = new TCPDF("L", PDF_UNIT, "A4", true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(4, 5, 4);
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false);
$pdf->SetTitle("kartu keluarga");
// auto page, margin bottom
$pdf->SetAutoPageBreak(TRUE, 4);
// image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// language-dependent strings
$pdf->setLanguageArray($l);
$pdf->SetFont('times', '', 8);
$pdf->AddPage();
$pdf->Cell(20, 1,"hello world",0,0, 'L');
$pdf->Cell(270, 1,"hello world",0,1, 'R');
$pdf->MultiCell(0,1, "laporan status", 0, 'C', 0, 1);
$pdf->Ln(4);
$tbl = <<<EOD
<table cellspacing="0" cellpadding="0" border="1">
    <tr>
        <td align="center">Title</td>
        <td align="center">Heading</td>
        <td align="center">Row</td>
    </tr>
    <tr>
    	<td>COL 2 - ROW 2 - COLSPAN 2<br />text line<br />text line<br />text line<br />text line</td>
    	 <td colspan="2">COL 3 - ROW 2<br />text line<br />text line</td>
    </tr>
    <tr>
       <td colspan="3">COL 3 - ROW 3</td>
    </tr>
</table>
EOD;
$pdf->writeHTML($tbl,true,false,false,false,'');
$pdf->Output("kk.pdf","I");

?>