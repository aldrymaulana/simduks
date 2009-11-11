<?php
include "../../fpdf.php";
include_once "../../includes/helpers.inc.php";

class PDF extends FPDF
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
    
    function __construct($penduduk_id){
        $this->FPDF('p','mm','A5');
        $this->AddFont("Calligrapher", '', 'calligra.php');
        $this->sql = "SELECT p.id as id, p.nik as nik, p.nama as nama, p.jenis_kelamin as jenis_kelamin, p.photo as photo,
        p.status_nikah as status_nikah, p.gol_darah as gol_darah, p.tmp_lahir as tmp_lahir, p.tgl_lahir as tgl_lahir,
        a.agama as agama, pen.pendidikan as pendidikan, pek.pekerjaan as pekerjaan, p.keluarga_id as keluarga_id,
        p.wni as wni FROM penduduk p, agama a, pendidikan pen, pekerjaan pek where p.id = $penduduk_id 
        AND p.agama_id = a.id AND p.pendidikan_id = pen.id AND p.pekerjaan_id = pek.id";
    }
    
    function Header(){
        $this->SetFont("Calligrapher",'',10);
        $this->Cell(0, 8, "PROPINSI JAWA TIMUR", 0, 0, 'C');
        $this->Ln(5);
        $this->SetFont("Calligrapher",'', 10);
        $this->Cell(0, 8, "KABUPATEN TULUNGAGUNG", 0, 0, 'C');
        $this->Ln(5);
    }
    
    function add_image($image){
        $this->Image("../../statics/images/foto/$image", 80, 25,0,0,'jpg');
       
    }
    
    function add_text(){
        $this->ln(4);
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
    $pdf = new PDF($penduduk_id);
    /*
    $pdf->AddPage();
    $pdf->add_image();
    $pdf->add_text();
    */
    $pdf->build();
    $pdf->Output();
}
?>