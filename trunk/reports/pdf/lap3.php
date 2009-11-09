<?php
include "../../fpdf.php";

class PDF extends FPDF
{
    function __construct(){
        $this->FPDF('l','mm','A5');
        $this->AddFont("Calligrapher", '', 'calligra.php');
    }
    
    function Header(){
        $this->SetFont("Calligrapher",'',12);
        $this->Cell(0, 10, "Kartu Tanda Anggota", 0, 0, 'C');
        $this->Ln(5);
        $this->SetFont("Helvetica",'', 11);
        $this->Cell(0, 10, "Kapal Tunda1 Pelindo 3 Perak", 0, 0, 'C');
        $this->Ln(5);
    }
    
    function add_image(){
        $this->Image("../../tutorial/logo.png", 160, 30);
    }
    
    function add_text(){
        $this->Ln();
        $this->Cell(0, 7, "Nama : Joko Sutrisno");
        $this->Ln(4);
        $this->Cell(0, 7, "Alamat : Jln. Nangka 10 Surabaya");
    }
    
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->add_image();
$pdf->add_text();
$pdf->Output();
?>