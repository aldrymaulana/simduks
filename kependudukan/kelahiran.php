<?php
// processing akta kelahiran
session_start();
include_once "../includes/helpers.inc.php";
include_once "../dbaccess/orangtua_controller.php";
if(isset($_POST['mode']))
{
	$ortu_controller = new OrangTuaController();
	$mode = $_POST['mode'];
	switch($mode)
	{
        case "add":
     		$nik_ayah = $_POST['nik_ayah'];
			$nik_ibu = $_POST['nik_ibu'];
			if($ortu_controller->check_orangtua($nik_ayah, $nik_ibu) <= 0){
                // insert new data
  			    $ortu_controller->insert($nik_ayah, $nik_ibu);
			} 
			// get orang_tua id 
			$orangtua_id = $ortu_controller->get_id($nik_ayah, $nik_ibu);
			$kartukeluarga_id = get_kartukeluarga_id($nik_ayah);
			$no_akte = $_POST['no_akte'];
			$nama = $_POST['nama'];
			$jenis_kelamin = $_POST['jenis_kelamin'];
			$golongan_darah = $_POST['gol_darah'];
			$tempat_lahir = $_POST['tempat_lahir'];
			$tanggal_lahir = $_POST['tanggal_lahir'];
			$jam_lahir = $_POST['jam_lahir'];
			$saksi1 = $_POST['saksi1'];
			$saksi2 = $_POST['saksi2'];
			
		    break;
		case "update":
		    break;
		case "delete":
		    break;
	}
}

function get_kartukeluarga_id($nik)
{
    $sql = "select keluarga_id from penduduk where nik = '$nik'";
	$connection = MysqlManager::get_connection();
	$result = $connection->query($sql);
	check_error($connection);
	$row = $result->fetch_object();
	MysqlManager::close_connection($connection);
	return $row->keluarga_id;
}
echo "<a id='report_link' href='kependudukan/kelahiran.php?q=report&id=1'>Sukses, klik disini untuk cetak</a>";
?>