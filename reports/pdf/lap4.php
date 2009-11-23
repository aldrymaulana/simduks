<?php
require_once "../../tcpdf/config/lang/eng.php";
require_once "../../tcpdf/tcpdf.php";
include_once "../../includes/helpers.inc.php";


$id = $_GET['pernikahan_id'];

$loader = new PernikahanLoader($id);
$loader->retrieve_data();

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

$pdf->Ln(10);

$pdf->SetFontSize(10);
$pdf->Cell(30, 1, "Nomor",0, 0,'L',0);
$pdf->MultiCell(70,1, $loader->no_pernikahan,0,'L',0,1);
$pdf->Cell(30, 1, "Tanggal", 0, 0, 'L', 0);
$date = strtotime($loader->tanggal_menikah);
$pdf->MultiCell(70,1, strftime(date("d F Y", $date)),0,'L',0,1);

$pdf->MultiCell(100,1, "Telah dilangsungkan akad nikah seorang laki-laki",0,'C',0,1);

$pdf->Cell(30, 1, "Nama", 0, 0, 'L', 0);
$pdf->MultiCell(70,1, $loader->pria,0,'L',0,1);
$pdf->Cell(30, 1, "Warga Negara", 0, 0, 'L', 0);
if($loader->pria_wni == "WNI"){
    $pdf->MultiCell(70,1, "Indonesia",0,'L',0,1);
}else {
    $pdf->MultiCell(70,1, "Asing",0,'L',0,1);
}
$pdf->Cell(30, 1, "Agama", 0, 0, 'L', 0);
$pdf->MultiCell(70,1, $loader->pria_agama,0,'L',0,1);

$pdf->MultiCell(100,1, "Dengan seorang wanita",0,'C',0,1);

$pdf->Cell(30, 1, "Nama", 0, 0, 'L', 0);
$pdf->MultiCell(70,1, $loader->wanita,0,'L',0,1);
$pdf->Cell(30, 1, "Warga Negara", 0, 0, 'L', 0);
if($loader->wanita_wni == 'WNI'){
    $pdf->MultiCell(70,1, "Indonesia",0,'L',0,1);
} else {
    $pdf->MultiCell(70, 1, "Asing", 0, "L", 0, 1);
}
$pdf->Cell(30, 1, "Agama", 0, 0, 'L', 0);
$pdf->MultiCell(70,1, $loader->wanita_agama,0,'L',0,1);

$pdf->MultiCell(100,1, "Dengan wali nikah",0,'C',0,1);
$pdf->Cell(30, 1, "Nama", 0, 0, 'L', 0);
$pdf->MultiCell(70,1, $loader->wali,0,'L',0,1);


$pdf->Output("pernikahan.pdf","I");

class PernikahanLoader
{
    public $pria;
    public $no_pernikahan;
    public $tanggal_menikah;
    public $pria_wni;
    public $pria_agama;
    public $wanita;
    public $wanita_wni;
    public $wanita_agama;
    public $wali;
    public $id;
    
    public function __construct($id){
        $this->id = $id;
    }
    
    public function retrieve_data(){
        $conn = MysqlManager::get_connection();
        $sql = "select n.no_pernikahan as nomor_pernikahan, n.tanggal as tanggal,
        n.wali as wali, p.nama as pria, p.wni as wni_pria, a.agama as agama_pria,
        pp.nama as wanita, pp.wni as wni_wanita, aa.agama as agama_wanita from pernikahan n,
        penduduk p, penduduk pp, agama a, agama aa where n.id = $this->id and
        n.pria = p.id and n.wanita = pp.id and p.agama_id = a.id and pp.agama_id = aa.id";
       
        $result = $conn->query($sql);
        check_error($conn);
        $row = $result->fetch_object();
        $this->pria = $row->pria;
        $this->no_pernikahan = $row->nomor_pernikahan;
        $this->tanggal_menikah = $row->tanggal;
        $this->wali = $row->wali;
        $this->pria_agama = $row->agama_pria;
        $this->pria_wni = $row->wni_pria;
        $this->wanita = $row->wanita;
        $this->wanita_agama = $row->agama_wanita;
        $this->wanita_wni = $row->wni_wanita;
        MysqlManager::close_connection($conn);
    }
}
?>