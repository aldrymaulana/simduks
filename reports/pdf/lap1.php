<?php
require_once "../../tcpdf/config/lang/eng.php";
require_once "../../tcpdf/tcpdf.php";
include_once "../../includes/helpers.inc.php";

$id = $_GET["id"];
$penduduk = new AktaLoader($id);
$penduduk->retrieve_data();

$pdf = new TCPDF("P",PDF_UNIT, "A4", true, "UTF-8", false);
$pdf->SetMargins(10, 20, 10);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false);
$pdf->SetTitle("Akta Kelahiran");
$pdf->SetAutoPageBreak(true, 10);


$pdf->AddPage();

// --------
$pdf->SetFont("times", '', 12);
$pdf->Cell(130, 1, "Nomor Induk Kependudukan",0,0,'L',0);
$pdf->Cell(70, 1, $penduduk->nik,0,0,'L',0);
$pdf->Ln(40);
$pdf->SetFontSize(18);
$pdf->MultiCell(200, 1, "PENCATATAN SIPIL", 0, 'C', 0, 1,'','', true);
if(strcmp($penduduk->wni, 'WNI')==0){
    $pdf->MultiCell(200, 1, "WARGA NEGARA:   INDONESIA", 0, 'C', 0, 1,'','', true);    
} else {
    $pdf->MultiCell(200, 1, "WARGA NEGARA:   ASING", 0, 'C', 0, 1,'','', true);
}

$pdf->MultiCell(200, 1, "KUTIPAN AKTA KELAHIRAN", 0, 'C', 0, 1,'','', true);
$pdf->Ln(40);
$tangal_lahir =  strtotime($penduduk->tanggal_lahir);
$pdf->SetFontSize(12);
$pdf->Write(1, "Berdasarkan Akta Kelahiran Nomor ...............$penduduk->no_akta ........",'', 0,'L',true);
$pdf->Write(1, "menurut stbld ..................... - ..........................",'', 0, 'L', true);
$pdf->Write(1, "bahwa di ....$penduduk->tempat_lahir .... pada tanggal ...".strftime(date('d F', $tangal_lahir))." tahun ".strftime(date('Y', $tangal_lahir))."  telah lahir", '',0, 'L', true);
$pdf->MultiCell(150, 1, " ---- ".strtoupper($penduduk->nama)." ----", 0, 'C', 0, 1,'','', true);
$pdf->Write(1, "anak $penduduk->jenis_kelamin, dari suami-istri ", '',0, 'L', true);
$pdf->Write(1, strtoupper($penduduk->ayah)." dan ".strtoupper($penduduk->ibu), '',0, 'L', true);
$pdf->Ln(20);
$tanggal_pembuatan = strtotime($penduduk->tanggal_pembuatan);
$pdf->Cell(100);
$pdf->MultiCell(100, 1, "Kutipan ini dikeluarkan....di Tulungagung......", 0, 'L', 0, 1, '','', true);
$pdf->Cell(100);
$pdf->MultiCell(100, 1, "pada tanggal .....".strftime(date('d F', $tanggal_pembuatan)).".......", 0, 'L', 0, 1, '','', true);
$pdf->Cell(100);
$pdf->MultiCell(100, 1, "....tahun ".strftime(date('Y', $tanggal_pembuatan))." ......", 0, 'L', 0, 1, '','', true);
$pdf->Cell(100);
$pdf->MultiCell(100, 1, "Kepala DINAS KEPENDUDUKAN DAN CATATAN SIPIL", 0, 'L', 0, 1, '','', true);
$pdf->Cell(100);
$pdf->MultiCell(100, 1, ".....KABUPATEN TULUNGAGUNG.....", 0, 'C', 0, 1, '','', true);
$pdf->Ln(15);
$pdf->Cell(100);
$pdf->MultiCell(100, 1, strtoupper(get_setting_value("kepala_capil")), 0, 'C', 0, 1, '','', true);


$pdf->Output("akta_kelahiran.pdf", "I");

class AktaLoader
{
    public $no_akta;
    public $nik;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $jenis_kelamin;
    public $wni;
    public $nama;
    public $ayah;
    public $ibu;
    public $tanggal_pembuatan;
    public $id;
    
    public function __construct($id){
        $this->id = $id;
    }
    
    
    public function retrieve_data(){
        $conn = MysqlManager::get_connection();
        $sql = "select p.nik as nik, p.nama as nama, p.tmp_lahir as tempat_lahir, p.tgl_lahir as tgl_lahir, 
        p.jenis_kelamin as jenis_kelamin, p.wni as wni, 
        a.no_akta as no_akta, a.created_at as tanggal_pembuatan, pp.nama as ayah, ppp.nama as ibu 
        from penduduk p, penduduk pp, penduduk ppp, akta_kelahiran a, orang_tua o where p.id = ".$this->id." and p.id = a.penduduk_id and p.orangtua_id = o.id and o.bapak_id = pp.id and o.ibu_id = ppp.id";
        
        
        $result = $conn->query($sql);
        check_error($conn);
        $row = $result->fetch_object();
        $this->nik = $row->nik;        
        $this->nama = $row->nama;
        $this->tempat_lahir = $row->tempat_lahir;
        $this->tanggal_lahir = $row->tgl_lahir;
        $this->jenis_kelamin = $row->jenis_kelamin;
        $this->wni = $row->wni;
        $this->no_akta = $row->no_akta;
        $this->tanggal_pembuatan = $row->tanggal_pembuatan;
        $this->ayah = $row->ayah;
        $this->ibu = $row->ibu;
        
        MysqlManager::close_connection($conn);
    }
}
?>