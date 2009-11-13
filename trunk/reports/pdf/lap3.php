<?php
require_once "../../tcpdf/config/lang/eng.php";
require_once "../../tcpdf/tcpdf.php";
include_once "../../includes/helpers.inc.php";

class PDF 
{
    private $sql;
    private $nik;
    private $nama;
    private $jenis_kelamin;
    private $photo;
    private $status_nikah;
    private $gol_darah;
    private $tempat_lahir;
    private $tgl_lahir;
    private $agama;
    private $pendidikan;
    private $pekerjaan;
    private $keluarga_id;
    private $wni;
    private $alamat;
    private $rt;
    private $rw;
    private $kelurahan;
    private $kecamatan;
    private $kodepos;
    private $penduduk_id;
    
    function __construct($penduduk_id){
        $this->FPDF('p','mm','A4');
        $this->AddFont("Calligrapher", '', 'calligra.php');
        $this->penduduk_id = $penduduk_id;
        $this->sql = "SELECT p.id as id, p.nik as nik, p.nama as nama, p.jenis_kelamin as jenis_kelamin, p.photo as photo,
        p.status_nikah as status_nikah, p.gol_darah as gol_darah, p.tmp_lahir as tmp_lahir, p.tgl_lahir as tgl_lahir,
        a.agama as agama, pen.pendidikan as pendidikan, pek.pekerjaan as pekerjaan, p.keluarga_id as keluarga_id,
        p.wni as wni FROM penduduk p, agama a, pendidikan pen, pekerjaan pek where p.id = $this->penduduk_id  
        AND p.agama_id = a.id AND p.pendidikan_id = pen.id AND p.pekerjaan_id = pek.id";
    }
    
    function Header(){
        $this->SetFont("Calligrapher",'',10);
        $this->Cell(0, 8, "PROPINSI JAWA TIMUR", 0, 0, 'C');
        $this->Ln(5);
        $this->SetFont("Calligrapher",'', 10);
        $this->Cell(0, 8, "KABUPATEN TULUNGAGUNG", 0, 0, 'C');
        
    }
    
    function add_image($image){
        $this->Image("../../statics/images/foto/$image", 80, 25,0,0,'jpg');       
    }
    
    function add_text(){
        //$this->ln(4);
        $this->SetFont("Helvetica",'', 6);
        $this->Cell(0, 7, "N.I.K ",1);
        $this->Cell(0, 7, ":$this->nik", 1);
        $this->Cell(0, 0," ",1);
        $this->Cell(0, 0," ",1);
        $this->Ln(3);
        $this->Cell(0, 7, "Nama");
        $this->Cell(0, 7, ":$this->nama",1);
        $this->Cell(0, 0," ",1);
        $this->Cell(0, 0," ",1);
        $this->Ln(3);
        $this->Cell(0, 7, "Tempat/Tgl.Lahir",1);
        $this->Cell(0, 7, ":$this->tempat_lahir, $this->tgl_lahir",1);
        $this->Cell(0, 0," ",1);
        $this->Cell(0, 0," ",1);
        $this->Ln(3);
        $this->Cell(0, 7, "Jenis Kelamin",1);
        $this->Cell(0, 7, ":$this->jenis_kelamin",1);
        $this->Cell(0, 7, "Gol. Darah",1);
        $this->Cell(0, 7, ":$this->gol_darah",1);
        $this->Ln(3);
        $this->Cell(0, 7, "Alamat", 1);
        $this->Cell(0, 7, ":$this->alamat", 1);
        $this->Cell(0, 0," ",1);
        $this->Cell(0, 0," ",1);
        $this->Ln(3);
        $this->Cell(0, 7, "R.T/R.W", 1);
        $this->Cell(0, 7, ":$this->rt/$this->rw");
        $this->Cell(0, 7, "Desa");
        $this->Cell(0, 7, ":$this->kelurahan");
        $this->Ln(3);
        $this->Cell(0, 7, "Kecamatan",1);
        $this->Cell(0, 7, " ", 1);
        $this->Cell(0, 0," ",1);
        $this->Cell(0, 0," ",1);
        $this->MultiCell(0, 7, "hello world of php reporting pdf yang buuruk");
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
    
    function build(){
        
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
        // building page
        $this->AddPage();        
        $this->add_text();
        $this->add_image($this->photo);
    }
}

if(isset($_GET['penduduk_id'])){
    $penduduk_id = $_GET['penduduk_id'];
    $pdf = new TCPDF("L", PDF_UNIT, "A7", true, 'UTF-8', false);
	// header data
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	// set margin
    // left, top, right
	$pdf->SetMargins(2, 5, 2);
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
    $pdf->Cell(40, 4, "KABUPATEN TULUNGAGUNG", 0,1,'C');    
    $pdf->Cell(30);
    $pdf->Cell(40, 4, "PROPINSI JAWA TIMUR", 0, 1, 'C');
    $pdf->SetFont("times",'',5);	
	$pdf->MultiCell(20,1, 'Nama', 0,'L', 0,0, '','',true);
    $pdf->MultiCell(20, 1, ': Heru Eko Susanto, ST',0, 'L',0, 1,'','', true);
    $pdf->MultiCell(20, 1,'Tempat/Tgl. Lahir', 0, 'L',0, 0,'','', true);
    $pdf->MultiCell(40, 1, ": Tulungagung, 19 November 1980", 0, 'L', 0, 1,'','', true);
    $pdf->MultiCell(20,1, 'Jenis Kelamin', 0,'L', 0,0, '','',true);
    $pdf->MultiCell(10, 1, ': Laki-Laki',0, 'L',0, 0,'','', true);
    $pdf->MultiCell(15,1, 'Gol. Darah', 0,'L', 0,0, '','',true);
    $pdf->MultiCell(8, 1, ": AB", 0, 'L', 0, 1,'','', true);
    $pdf->MultiCell(20,1, 'Alamat', 0,'L', 0,0, '','',true);
    $pdf->MultiCell(20, 1, ': Jl. Nangka',0, 'L',0, 1,'','', true);
    $pdf->Cell(5);
    $pdf->MultiCell(10,1, "R.T/R.W", 0,'L',0, 0,'','', true);
    $pdf->MultiCell(10,1,"005/001",0,'L',0,0,'','', true);
    $pdf->MultiCell(10,1,"Desa",0,'L',0,0,'','',true);
    $pdf->MultiCell(15,1,"Gedangan",0,'L',0,1,'','', true);
    $pdf->Cell(5);
    $pdf->MultiCell(10,1, "Kec.", 0,'L',0, 0,'','', true);
    $pdf->MultiCell(15,1,"Campurdarat",0,'L',0,0,'','', true);
    $pdf->MultiCell(10,1,"Kodepos",0,'L',0,0,'','',true);
    $pdf->MultiCell(10,1,"66272",0,'L',0,1,'','', true);
    
	$pdf->MultiCell(40, 5, 'B test multicell line 1 test multicell line 2 test multicell line 3', 0, 'R', 0, 1);
	$pdf->MultiCell(40, 5, 'C test multicell line 1 test multicell line 2 test multicell line 3', 0, 'C', 0, 0);
	$pdf->MultiCell(40, 5, 'D test multicell line 1 test multicell line 2 test multicell line 3'."\n", 0, 'J', 0, 2);
	$pdf->MultiCell(40, 5, 'E test multicell line 1 test multicell line 2 test multicell line 3', 0, 'L', 0, 2);
    // add foto image
    $pdf->Image("../../statics/images/foto/3.jpg",70,15,20,25,'','','C',true);
    $pdf->lastPage();
	$pdf->Output('lap3.pdf', 'I');
}
?>
