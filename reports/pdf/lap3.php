<?php
require_once "../../tcpdf/config/lang/eng.php";
require_once "../../tcpdf/tcpdf.php";
include_once "../../includes/helpers.inc.php";
class KTP
{
    public $sql;
    public $nik;
    public $nama;
    public $jenis_kelamin;
    public $photo;
    public $status_nikah;
    public $gol_darah;
    public $tempat_lahir;
    public $tgl_lahir;
    public $agama;
    public $pendidikan;
    public $pekerjaan;
    public $keluarga_id;
    public $wni;
    public $alamat;
    public $rt;
    public $rw;
    public $kelurahan;
    public $kecamatan;
    public $kodepos;
    public $penduduk_id;
    
    function __construct($penduduk_id){       
        $this->penduduk_id = $penduduk_id;
        $this->sql = "SELECT p.id as id, p.nik as nik, p.nama as nama, p.jenis_kelamin as jenis_kelamin, p.photo as photo,
        p.status_nikah as status_nikah, p.gol_darah as gol_darah, p.tmp_lahir as tmp_lahir, p.tgl_lahir as tgl_lahir,
        a.agama as agama, pen.pendidikan as pendidikan, pek.pekerjaan as pekerjaan, p.keluarga_id as keluarga_id,
        p.wni as wni FROM penduduk p, agama a, pendidikan pen, pekerjaan pek where p.id = $this->penduduk_id  
        AND p.agama_id = a.id AND p.pendidikan_id = pen.id AND p.pekerjaan_id = pek.id";
    }
    
    
    function add_image($image){
        $this->Image("../../statics/images/foto/$image", 80, 25,0,0,'jpg');       
    }
            
    function retrieve_data(){
        
        $connection = MysqlManager::get_connection();
        
        $result = $connection->query($this->sql);
        check_error($connection);
        $row = $result->fetch_object();
        $this->nik = $row->nik;
        $this->nama = $row->nama;
        $this->jenis_kelamin = $row->jenis_kelamin;
        $this->photo = $row->photo;
        $this->status_nikah = $row->status_nikah;
        $this->gol_darah = $row->gol_darah;
        $this->tempat_lahir = $row->tmp_lahir;
        $this->tgl_lahir = $row->tgl_lahir;
        $this->agama = $row->agama;
        $this->pendidikan = $row->pendidikan;
        $this->pekerjaan = $row->pekerjaan;
        $this->keluarga_id = $row->keluarga_id;
        $this->wni = $row->wni;
        // --
        $sql = "select alamat_id from keluarga where id = $this->keluarga_id";
        $result = $connection->query($sql);
        check_error($connection);
        $alamat_id = $result->fetch_object()->alamat_id;
        $sql = "select a.alamat as alamat, a.rukun_tetangga as rt, a.rukun_warga as rw,
            kel.nama_kelurahan as kelurahan, kec.nama_kecamatan as kecamatan, kec.kodepos as kodepos 
            from alamat a, kelurahan kel, kecamatan kec where a.id = $alamat_id and a.kelurahan_id = kel.id and
            kel.kecamatan_id = kec.id ";
        $result = $connection->query($sql);
        check_error($connection);
        $row = $result->fetch_object();
        $this->alamat = $row->alamat;
        $this->rt = $row->rt;
        $this->rw = $row->rw;
        $this->kelurahan = $row->kelurahan;
        $this->kecamatan = $row->kecamatan;
        $this->kodepos = $row->kodepos;
        MysqlManager::close_connection($connection);
    }
}

if(isset($_GET['penduduk_id'])){
    $penduduk_id = $_GET['penduduk_id'];
    $ktp = new KTP($penduduk_id);    $ktp->retrieve_data();
    
    $pdf = new TCPDF("L", PDF_UNIT, "A7", true, 'UTF-8', false);
	// header data
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	// set margin
    // left, top, right
	$pdf->SetMargins(4, 5, 4);
	// remove default header/footer
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	// setting title
	$pdf->SetTitle('ktp');
	// auto page breaks
    // auto page, margin bottom
	$pdf->SetAutoPageBreak(TRUE, 4);
	// image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	// language-dependent strings
	$pdf->setLanguageArray($l);
	// -------------------------------
	// set font
	$pdf->SetFont('times', '', 8);
	// add a page
	$pdf->AddPage();
    $pdf->Cell(30);
    $pdf->Cell(40, 4, "PROPINSI JAWA TIMUR", 0,1,'C');    
    $pdf->Cell(30);
    $pdf->Cell(40, 4, "KABUPATEN TULUNGAGUNG", 0, 1, 'C');
    $pdf->SetFont("times",'',5);	
	$pdf->MultiCell(20,1, 'Nama', 0,'L', 0,0, '','',true);
    $pdf->MultiCell(20, 1, ": $ktp->nama",0, 'L',0, 1,'','', true);
	$dob = strtotime($ktp->tgl_lahir);
	$dob_str = strftime(date("d-F-Y", $dob));
    $pdf->MultiCell(20, 1,'Tempat/Tgl. Lahir', 0, 'L',0, 0,'','', true);
    $pdf->MultiCell(40, 1, ": ".$ktp->tempat_lahir.", ".$dob_str, 0, 'L', 0, 1,'','', true);
    $pdf->MultiCell(20,1, 'Jenis Kelamin', 0,'L', 0,0, '','',true);
    $pdf->MultiCell(10, 1, ': '.$ktp->jenis_kelamin,0, 'L',0, 0,'','', true);
    $pdf->MultiCell(15,1, 'Gol. Darah', 0,'L', 0,0, '','',true);
    $pdf->MultiCell(8, 1, ": $ktp->gol_darah", 0, 'L', 0, 1,'','', true);
    $pdf->MultiCell(20,1, 'Alamat', 0,'L', 0,0, '','',true);
    $pdf->MultiCell(20, 1, ": $ktp->alamat",0, 'L',0, 1,'','', true);
    $pdf->Cell(5);
    $pdf->MultiCell(10,1, "R.T/R.W", 0,'L',0, 0,'','', true);
    $pdf->MultiCell(20,1,": ".sprintf("%03d",$ktp->rt)."/".sprintf("%03d",$ktp->rw),0,'L',0,0,'','', true);
    $pdf->MultiCell(10,1,"Desa",0,'L',0,0,'','',true);
    $pdf->MultiCell(15,1,": $ktp->kelurahan",0,'L',0,1,'','', true);
    $pdf->Cell(5);
    $pdf->MultiCell(10,1, "Kec.", 0,'L',0, 0,'','', true);
    $pdf->MultiCell(20,1,": $ktp->kecamatan",0,'L',0,0,'','', true);
    $pdf->MultiCell(10,1,"Kodepos",0,'L',0,0,'','',true);
    $pdf->MultiCell(15,1,": $ktp->kodepos",0,'L',0,1,'','', true);
    
    $pdf->MultiCell(20,1, 'Agama', 0,'L', 0,0, '','',true);
    $pdf->MultiCell(15, 1, ": $ktp->agama",0, 'L',0, 0,'','', true);    
    $pdf->MultiCell(20,1,"Status Perkawinan",0,'L',0,0,'','',true);
    $pdf->MultiCell(10,1,": $ktp->status_nikah",0,'L',0,1,'','', true);
    
    $pdf->MultiCell(20,1, 'Pekerjaan', 0,'L', 0,0, '','',true);
    $pdf->MultiCell(20, 1, ": $ktp->pekerjaan",0, 'L',0, 1,'','', true);
    $pdf->MultiCell(20,1,"Kewarganegaraan",0,'L',0,0,'','',true);
    $pdf->MultiCell(10,1,": $ktp->wni",0,'L',0,1,'','', true);
    
	$dm = strftime(date('d-m', $dob));
	$year = strftime(date('Y'));
    $year = (int)$year;
	$year += 5;

	$pdf->MultiCell(20,1,"Berlaku Hingga",0,'L',0,0,'','',true);
    $pdf->MultiCell(15,1,": $dm-$year",0,'L',0,0,'','', true);
    $pdf->Cell(20);
    $pdf->Cell(0, 1, "TULUNGAGUNG, ".strftime(date('m-F-Y')),0, 1, 'C', 0,'',0);
    $pdf->Cell(55);
    $pdf->Cell(0,1, 'an. BUPATI TULUNGAGUNG', 0,1,'C',0,'',0);
    $pdf->Cell(55);
    $pdf->Cell(0,1, 'KEPALA DINAS',0,1,'C',0,'',0);
    $pdf->Cell(55);
    $pdf->Cell(0,3, 'KEPENDUDUKAN DAN CATATAN SIPIL',0,1,'C',0,'',0);
    // add foto image    $pdf->Ln(5);
    $pdf->Cell(55);
    $pdf->Cell(0,1, get_setting_value("kepala_capil"), 0,1, 'C', 0, '', 0);
    $pdf->Image("../../statics/images/foto/$ktp->photo",70,15,20,25,'','','C',true);
    $pdf->lastPage();
	$pdf->Output('ktp.pdf', 'I');
}


?>
