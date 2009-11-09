<?php
include "../../fpdf.php";

class PDF extends FPDF
{
    function __construct(){
        $this->FPDF('l','mm','A5');
    }
    
    function Header(){
        $this->SetFont("Times",'',12);
        $this->Cell(0, 10, "Kartu Tanda Anggota", 0, 0, 'C');
        $this->Ln(5);
        $this->SetFont("Times",'', 11);
        $this->Cell(0, 10, "Kapal Tunda1 Pelindo 3 Perak", 0, 0, 'C');
        $this->Ln(5);
    }    
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->Output();
?>