<?php
require_once "../../tcpdf/config/lang/eng.php";
require_once "../../tcpdf/tcpdf.php";
include_once "../../includes/helpers.inc.php";

$kode = $_GET["kode"];

$kk = new KKLoader($kode);
$kk->build();

$pdf = new TCPDF("L", PDF_UNIT, "FOLIO", true, 'UTF-8', false);
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

$pdf->AddPage();
// -------------- header ------------------------
$pdf->SetFont('times', '', 32);
$pdf->MultiCell(270, 1, "KARTU KELUARGA", 0,'C',0,1,'','',true);
$pdf->SetFontSize(20);
$pdf->MultiCell(270,1,"No. $kk->_kode_keluarga",0,'C',0,1,'','', true);

$pdf->SetFontSize(10);
$pdf->Ln(4);
$pdf->MultiCell(40, 1,"Nama Kepala Keluarga",0,'L',0,0);
$pdf->MultiCell(60, 1,": $kk->kepala_keluarga", 0, 'L',0,0);
$pdf->Cell(120);
$pdf->MultiCell(35, 1, "Kecamatan", 0, 'L', 0, 0);
$pdf->MultiCell(65, 1, ": $kk->kecamatan",0,'L',0,1);

$pdf->MultiCell(40, 1,"Alamat",0,'L',0,0);
$pdf->MultiCell(60, 1,": $kk->alamat", 0, 'L',0,0);
$pdf->Cell(120);
$pdf->MultiCell(35, 1, "Kabupaten/Kota", 0, 'L', 0, 0);
$pdf->MultiCell(65, 1, ": TULUNGAGUNG",0,'L',0,1);

$pdf->MultiCell(40, 1,"RT / RW",0,'L',0,0);
$pdf->MultiCell(60, 1,": ".sprintf("%03d",$kk->rw)." ".sprintf("%03d",$kk->rw), 0, 'L',0,0);
$pdf->Cell(120);
$pdf->MultiCell(35, 1, "Kode Pos",0, 'L', 0, 0);
$pdf->MultiCell(65, 1, ": $kk->kodepos",0,'L',0,1);

$pdf->MultiCell(40, 1,"Kelurahan / Desa",0,'L',0,0);
$pdf->MultiCell(60, 1,": $kk->kelurahan", 0, 'L',0,0);
$pdf->Cell(120);
$pdf->MultiCell(35, 1, "Propinsi", 0, 'L', 0, 0);
$pdf->MultiCell(65, 1, ": JAWA TIMUR",0,'L',0,1);
// ----------------- header -------------------- */

$pdf->Ln(4);

$tbl = "
<table cellspacing=\"0\" cellpadding=\"0\" border=\"1\">
    <tr>
        <td  align=\"center\" width=\"25\">No</td>
        <td  align=\"center\" width=\"230\">Nama Lengkap</td>
        <td  align=\"center\">NIK / NIKS</td>
        <td  align=\"center\">Jenis Kelamin</td>
        <td  align=\"center\">Tempat Lahir</td>
        <td  align=\"center\" width=\"70\">Tanggal Lahir</td>
        <td  align=\"center\" width=\"80\">Agama</td>
        <td  align=\"center\" width=\"100\">Pendidikan</td>
        <td  align=\"center\">Pekerjaan</td>
    </tr>
    <tr>
        <td align=\"center\" width=\"25\">1</td>
        <td align=\"center\" width=\"230\">2</td>
        <td align=\"center\">3</td>
        <td align=\"center\">4</td>
        <td align=\"center\">5</td>
        <td align=\"center\" width=\"70\">6</td>
        <td align=\"center\" width=\"80\">7</td>
        <td align=\"center\" width=\"100\">8</td>
        <td align=\"center\">9</td>
    </tr>";
$index = 1;
$items = "";
foreach($kk->penduduks as $penduduk){
$item = "
<tr>
    <td align=\"center\" width=\"25\">$index</td>
    <td align=\"center\" width=\"230\">".$penduduk['nama']."</td>
    <td align=\"center\">".$penduduk['nik']."</td>
    <td align=\"center\">".$penduduk['jenis_kelamin']."</td>
    <td align=\"center\">".$penduduk['tmp_lahir']."</td>
    <td align=\"center\" width=\"70\">".$penduduk['tgl_lahir']."</td>
    <td align=\"center\" width=\"80\">".$penduduk['agama']."</td>
    <td align=\"center\" width=\"100\">".$penduduk['agama']."</td>
    <td align=\"center\">".$penduduk['pekerjaan']."</td>
</tr>
";
$items .= $item;
$index++;
}
$tbl .= $items."</table>";

$pdf->writeHTML($tbl,true,false,false,false,'');
$pdf->Ln(4);

$tbl = "
<table cellspacing=\"0\" cellpadding=\"0\" border=\"1\">
    <tr>
        <td  align=\"center\" width=\"25\">No</td>
        <td  align=\"center\">Status Perkawinan</td>
        <td  align=\"center\">Status Hubungan Dalam Keluarga</td>
        <td  align=\"center\">Kewarganegaraan</td>
        <td  align=\"center\" colspan=\"2\">Dokumen Imigrasi</td>
        <td  align=\"center\" colspan=\"2\" width=\"320\">Nama Orang Tua</td>        
    </tr>
    <tr>
        <td align=\"center\" width=\"25\"></td>
        <td align=\"center\"></td>
        <td align=\"center\"></td>
        <td align=\"center\"></td>
        <td align=\"center\">No. Paspor</td>
        <td align=\"center\">No. KITAS/KITAP</td>
        <td align=\"center\" width=\"160\">Ayah</td>
        <td align=\"center\" width=\"160\">Ibu</td>            
    </tr>
    <tr>
        <td align=\"center\" width=\"25\"></td>
        <td align=\"center\">10</td>
        <td align=\"center\">11</td>
        <td align=\"center\">12</td>
        <td align=\"center\">13</td>
        <td align=\"center\">14</td>
        <td align=\"center\" width=\"160\">15</td>
        <td align=\"center\" width=\"160\">16</td>
        
    </tr>";
$index = 1;
$items = "";
foreach($kk->penduduks as $penduduk){
$item = "<tr>
        <td align=\"center\" width=\"25\">".$index."</td>
        <td align=\"center\">".$penduduk["status_nikah"]."</td>
        <td align=\"center\">".$penduduk["status_hub_kel"]."</td>
        <td align=\"center\">".$penduduk["wni"]."</td>
        <td align=\"center\">-</td>
        <td align=\"center\">-</td>
        <td align=\"center\" width=\"160\">".$penduduk["orang_tua"]["ayah"]."</td>
        <td align=\"center\" width=\"160\">".$penduduk["orang_tua"]["ibu"]."</td>            
    </tr>";
$items .= $item;
$index++;
}
$tbl .= $items."</table>";

$pdf->writeHTML($tbl,true,false,false,false,'');
$pdf->Ln(4);
$pdf->MultiCell(40, 1,"Dikeluarkan Tanggal",0,'L',0,0);
$current_date = strftime(date('d F Y'));
$pdf->MultiCell(60, 1," $current_date", 1, 'C',0,0);
$pdf->Cell(40);
$pdf->MultiCell(40, 1,"Kepala Keluarga",0,'L',0,0);
$pdf->Cell(40);
$pdf->MultiCell(60, 1,"Tulungagung, $current_date",0,'C',0,1);
$pdf->Cell(200);
$pdf->MultiCell(100, 1, "Kepala Dinas Kependudukan Dan Catatan Sipil",0,'C',0,1);
$pdf->Cell(230);
$pdf->MultiCell(50,1, "Kabupaten Tulungagung",0,'C',0,1);
$pdf->Ln(8);
$pdf->Cell(140);
$pdf->MultiCell(30, 1,"$kk->kepala_keluarga",0,'C',0,0);
$pdf->Cell(60);
$pdf->MultiCell(40, 1,get_setting_value("kepala_capil"),0,'C',0,1);

$pdf->Output("kk.pdf","I");

class KKLoader
{
    public $_kode_keluarga;
    public $_alamat_id;
    public $_no_formulir;
    public $_keluarga_id;
    
    public $kepala_keluarga = "";
    public $alamat;
    public $rt;
    public $rw;
    public $kelurahan;
    public $kecamatan;
    public $kodepos;
    public $penduduks = array();
    
    public function __construct($id){
        $this->_keluarga_id = $id;
    }
    
    public function build(){
        $sql = "select * from keluarga where id = ".$this->_keluarga_id;
        $conn = MysqlManager::get_connection();
        $result = $conn->query($sql);
        check_error($conn);        
        $row = $result->fetch_object();
        $this->_keluarga_id = $row->id;
        $this->_alamat_id = $row->alamat_id;
        $this->_no_formulir = $row->no_formulir;
        $this->_kode_keluarga = $row->kode_keluarga;
        //echo $this->_keluarga_id;
        $sql = "select a.alamat as alamat, a.rukun_tetangga as rt, a.rukun_warga as rw,
            kel.nama_kelurahan as kelurahan, kec.nama_kecamatan as kecamatan, kec.kodepos as kodepos 
            from alamat a, kelurahan kel, kecamatan kec where a.id = $this->_alamat_id and a.kelurahan_id = kel.id and
            kel.kecamatan_id = kec.id ";
        $result = $conn->query($sql);
        check_error($conn);
        $row = $result->fetch_object();
        $this->alamat = $row->alamat;
        $this->rt = $row->rt;
        $this->rw = $row->rw;
        $this->kelurahan = $row->kelurahan;
        $this->kecamatan = $row->kecamatan;
        $this->kodepos = $row->kodepos;
        
        $sql = "SELECT p.id as id, p.nik as nik, p.nama as nama, p.jenis_kelamin as jenis_kelamin,
            p.status_nikah as status_nikah, p.status_hub_kel as status_hub_kel,
            p.gol_darah as gol_darah, p.tmp_lahir as tmp_lahir, p.tgl_lahir as tgl_lahir,p.orangtua_id as orangtua_id, 
            a.agama as agama, pen.pendidikan as pendidikan, pek.pekerjaan as pekerjaan, p.penghasilan as penghasilan, 
            p.wni as wni FROM penduduk p, agama a, pendidikan pen, pekerjaan pek where p.keluarga_id = $this->_keluarga_id 
            AND p.agama_id = a.id AND p.pendidikan_id = pen.id AND p.pekerjaan_id = pek.id";
        $result = $conn->query($sql);
        check_error($conn);
        while($row = $result->fetch_object()){
            $penduduk = array();
            $penduduk["nik"] = $row->nik;
            $penduduk["nama"] = $row->nama;
            $penduduk["jenis_kelamin"] = $row->jenis_kelamin;
            $penduduk["status_nikah"] = $row->status_nikah;
            $penduduk["status_hub_kel"] = $row->status_hub_kel;
            if(strcmp($row->status_hub_kel, "Kepala Keluarga") == 0){
                $this->kepala_keluarga = $row->nama;
            }
            $penduduk["gol_darah"]= $row->gol_darah;
            $penduduk["tmp_lahir"]= $row->tmp_lahir;
            $penduduk["tgl_lahir"] = $row->tgl_lahir;
            $penduduk["agama"] = $row->agama;
            $penduduk["pendidikan"] = $row->pendidikan;
            $penduduk["pekerjaan"] = $row->pekerjaan;
            $penduduk["penghasilan"] = $row->penghasilan;
            $penduduk["wni"] = $row->wni;            
            $penduduk["orang_tua"] = $this->get_orang_tua($row->orangtua_id);
            $this->penduduks[] = $penduduk;
        }
    }
    
    private function get_orang_tua($id){
        $resp = array();        
        if(strlen($id) > 0){
            $sql = "select p.nama as ayah, pp.nama as ibu from penduduk p, penduduk pp,
            orang_tua o where p.id = o.bapak_id and pp.id = o.ibu_id and o.id = $id";
            
            $conn = MysqlManager::get_connection();
            $result = $conn->query($sql);
            check_error($conn);
            $row = $result->fetch_object();            
            $resp["ayah"] = $row->ayah;
            $resp["ibu"] = $row->ibu;
            MysqlManager::close_connection($conn);
        } else {
            $resp["ayah"] = "";
            $resp["ibu"] = "";
        }
        return $resp;
    }
}
?>