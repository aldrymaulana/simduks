<?php
// processing akta kelahiran
session_start();
include_once "../dbaccess/orangtua_controller.php";
if(isset($_POST['mode']))
{
	$connection = MysqlManager::get_connection();
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
			//insert datapenduduk
			$kecamatan_id = $_POST['kecamatan_id'];
			$laki = $jenis_kelamin == 'Perempuan' ? false : true;
			$nik = nik($kecamatan_id, $tanggal_lahir, $laki);
			$sql = "insert into penduduk set nik = '$nik', nama = '$nama', status_hub_kel = 'Anak',
                tmp_lahir = '$tempat_lahir', tgl_lahir = '$tanggal_lahir', 
                gol_darah = '$golongan_darah', 
                status_nikah = 'Tidak kawin', jenis_kelamin = '$jenis_kelamin',
                keluarga_id = $kartukeluarga_id, orangtua_id = $orangtua_id";				
			$connection->query($sql);
			check_error($connection);
			//insert akte penduduk
			$id_anak = $ortu_controller->get_penduduk_id($nik);
			$sql = "insert into akta_kelahiran set penduduk_id = $id_anak, no_akta = '$no_akte', jam_lahir = '$jam_lahir', saksi1 = '$saksi1',
				saksi2 = '$saksi2', created_at = now()";
			$connection->query($sql);
			check_error($connection);
			echo "<a id='report_link' href='reports/pdf/lap1.php?nik=$nik'>Sukses, klik disini untuk cetak</a>";
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

?>