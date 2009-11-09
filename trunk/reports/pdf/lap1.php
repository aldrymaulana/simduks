<?php
include "../../fpdf.php";

class PDF extends FPDF
{
    function Header(){
        $this->SetFont("Calligrapher", "", 20);     
        $this->Cell(0, 10, "Hello World of Report", 0, 0, 'C');
        $this->Ln(20);
    }
    
    public function __construct(){
        $this->FPDF('p');
        $this->AddFont("Calligrapher", '', 'calligra.php');
    }
    
    function print_chapter($file_name){
        $file = fopen($file_name, 'r');
        $txt = fread($file, filesize($file_name));
        fclose($file);
        $this->AddPage();
        $this->SetFont('Times','',12);
        $txt = str_ireplace("#cc1", "Heru Eko Susanto", $txt);
        $this->MultiCell(0, 10, $txt);
    }
}

$pdf = new PDF();
$pdf->AddFont("Calligrapher",'', 'calligra.php');
$pdf->SetFont('Calligrapher','',12);
$pdf->print_chapter("lap1.txt");
$pdf->Output();
?>