<?php
require_once "../../tcpdf/config/lang/eng.php";
require_once "../../tcpdf/tcpdf.php";
include_once "../../includes/helpers.inc.php";

if(isset($_GET['kode_keluarga'])){
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
    $pdf->MultiCell(270,1,"No. 3504162501080002",0,'C',0,1,'','', true);
    
    $pdf->SetFontSize(10);
    $pdf->Ln(4);
    $pdf->MultiCell(40, 1,"Nama Kepala Keluarga",1,'L',0,0);
    $pdf->MultiCell(60, 1,": HERU EKO SUSANTO", 1, 'L',0,0);
    $pdf->Cell(120);
    $pdf->MultiCell(35, 1, "Kecamatan", 1, 'L', 0, 0);
    $pdf->MultiCell(65, 1, ": CAMPURDARAT",1,'L',0,1);
    
    $pdf->MultiCell(40, 1,"Alamat",1,'L',0,0);
    $pdf->MultiCell(60, 1,": Jl. Nangka 30", 1, 'L',0,0);
    $pdf->Cell(120);
    $pdf->MultiCell(35, 1, "Kabupaten/Kota", 1, 'L', 0, 0);
    $pdf->MultiCell(65, 1, ": TULUNGAGUNG",1,'L',0,1);
    
    $pdf->MultiCell(40, 1,"RT / RW",1,'L',0,0);
    $pdf->MultiCell(60, 1,": 005 001", 1, 'L',0,0);
    $pdf->Cell(120);
    $pdf->MultiCell(35, 1, "Kode Pos",1, 'L', 0, 0);
    $pdf->MultiCell(65, 1, ": CAMPURDARAT",1,'L',0,1);
    
    $pdf->MultiCell(40, 1,"Kelurahan / Desa",1,'L',0,0);
    $pdf->MultiCell(60, 1,": GEDANGAN", 1, 'L',0,0);
    $pdf->Cell(120);
    $pdf->MultiCell(35, 1, "Propinsi", 1, 'L', 0, 0);
    $pdf->MultiCell(65, 1, ": JAWA TIMUR",1,'L',0,1);
    // ----------------- header --------------------
    
    $pdf->Ln(4);
    $tbl = <<<EOD
    <table cellspacing="0" cellpadding="0" border="1">
        <tr>
            <td  align="center" width="25">No</td>
            <td  align="center" width="230">Nama Lengkap</td>
            <td  align="center">NIK / NIKS</td>
            <td  align="center">Jenis Kelamin</td>
            <td  align="center">Tempat Lahir</td>
            <td  align="center" width="70">Tanggal Lahir</td>
            <td  align="center" width="80">Agama</td>
            <td  align="center" width="100">Pendidikan</td>
            <td  align="center">Pekerjaan</td>
        </tr>
        <tr>
            <td align="center" width="25">1</td>
            <td align="center" width="230">2</td>
            <td align="center">3</td>
            <td align="center">4</td>
            <td align="center">5</td>
            <td align="center" width="70">6</td>
            <td align="center" width="80">7</td>
            <td align="center" width="100">8</td>
            <td align="center">9</td>
        </tr>
        <tr>
            <td align="center" width="25">1</td>
            <td align="center" width="230">Heru Eko Susanto</td>
            <td align="center">3504041110790002</td>
            <td align="center">Laki-laki</td>
            <td align="center">Tulungagung</td>
            <td align="center" width="70">19-11-1980</td>
            <td align="center" width="80">khonghucu</td>
            <td align="center" width="100">Strata 1</td>
            <td align="center">Karyawan Swasta</td>
        </tr>
    </table>
    EOD;
    $pdf->writeHTML($tbl,true,false,false,false,'');
    
    //--------------------------------
    $pdf->Ln(4);
    $tbl = <<<EOD
    <table cellspacing="0" cellpadding="0" border="1">
        <tr>
            <td  align="center" width="25">No</td>
            <td  align="center">Status Perkawinan</td>
            <td  align="center">Status Hubungan Dalam Keluarga</td>
            <td  align="center">Kewarganegaraan</td>
            <td  align="center" colspan="2">Dokumen Imigrasi</td>
            <td  align="center" colspan="2" width="320">Nama Orang Tua</td>        
        </tr>
        <tr>
            <td align="center" width="25"></td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">No. Paspor</td>
            <td align="center">No. KITAS/KITAP</td>
            <td align="center" width="160">Ayah</td>
            <td align="center" width="160">Ibu</td>
            
        </tr>
        <tr>
            <td align="center" width="25"></td>
            <td align="center">10</td>
            <td align="center">11</td>
            <td align="center">12</td>
            <td align="center">13</td>
            <td align="center">14</td>
            <td align="center" width="160">15</td>
            <td align="center" width="160">16</td>
            
        </tr>
        <tr>
            <td align="center" width="25">1</td>
            <td align="center">Kawin</td>
            <td align="center">Kepala Keluarga</td>
            <td align="center">Indonesia</td>
            <td align="center">-</td>
            <td align="center">-</td>
            <td align="center" width="160">Mudjilan</td>
            <td align="center" width="160">Sumiati</td>
            
        </tr>
    </table>
    EOD;
    $pdf->writeHTML($tbl,true,false,false,false,'');
    $pdf->Ln(4);
    $pdf->MultiCell(40, 1,"Dikeluarkan Tanggal",0,'L',0,0);
    $pdf->MultiCell(60, 1," 3 JUNI 2008", 1, 'C',0,0);
    $pdf->Cell(40);
    $pdf->MultiCell(40, 1,"Kepala Keluarga",0,'L',0,0);
    $pdf->Cell(40);
    $pdf->MultiCell(60, 1,"Tulungagung, 3 JUNI 2008",0,'C',0,1);
    $pdf->Cell(200);
    $pdf->MultiCell(100, 1, "Kepala Dinas Kependudukan Dan Catatan Sipil",0,'C',0,1);
    $pdf->Cell(230);
    $pdf->MultiCell(50,1, "Kabupaten Tulungagung",0,'C',0,1);
    $pdf->Ln(8);
    $pdf->Cell(140);
    $pdf->MultiCell(30, 1,"Heru Eko Susanto",0,'C',0,0);
    $pdf->Cell(60);
    $pdf->MultiCell(40, 1,get_setting_value("kepala_capil"),0,'C',0,1);
    $pdf->Output("kk.pdf","I");
}
?>