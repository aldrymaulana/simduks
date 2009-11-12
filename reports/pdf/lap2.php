<?php
include "../../fpdf.php";
include_once "../../includes/helpers.inc.php";

class PDF extends FPDF
{
    function Header(){
        $this->SetFont("Calligrapher", "", 20);     
        $this->Cell(0, 10, "Hello World of Report", 0, 0, 'C');
        $this->Ln(10);
    }
    
    function __construct(){
        $this->FPDF('l');
        $this->AddFont("Calligrapher", '', 'calligra.php');
    }
    
    function add_table(){
        $this->SetFont("Times",'',10);
        
        $this->Cell(0, 5, "Nama : Joni", 0, 0,'L');
        $this->Cell(80);
        $this->Cell(0, 5, "Alamat : Jl. Nangka 10 \nSurabaya", 0, 0,'R');
        $this->Ln();
        $this->Cell(0, 5, "Kec : Ploso", 0, 0,'L');
        $this->Ln();
        $this->Cell(0, 5, "Kec : Ploso", 0, 0,'L');
        $this->Ln();
        $this->Cell(0, 5, "Kec : Ploso", 0, 0,'L');
        $this->Ln();
        $this->Cell(0, 5, "Kec : Ploso", 0, 0,'L');
        $this->Ln(10);
        $w = array(55, 55, 55, 55, 55);
        $this->SetLineWidth(0.3);
        $header=array('Country','Capital','Area (sq km)','Pop. (thousands)', 'django');
        
        for($i = 0; $i < count($w); $i++){
            $this->Cell($w[$i], 10, $header[$i], 1, 0,'C');
        }
        $this->Ln();
    }
}

if(isset($_GET['kk_id'])){
    $penduduk_id = $_GET['kk_id'];
    
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->add_table();
    $pdf->Output();   
}
?>