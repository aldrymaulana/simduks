<?php
include_once "controller_helpers.php";

class OrangTuaController
{
    public function __construct(){
	}
	
	public function get_id($nik_ayah, $nik_ibu){
		$connection = MysqlManager::get_connection();		
		$id_ayah = $this->get_penduduk_id($nik_ayah);		
		$id_ibu = $this->get_penduduk_id($nik_ibu);
		$result = $connection->query("select id from orang_tua where bapak_id = $id_ayah and ibu_id = $id_ibu");
		check_error($connection);
		$row = $result->fetch_object();
		MysqlManager::close_connection($connection);
		return $row->id;
	}

   public function insert($nik_ayah, $nik_ibu) {
       $connection = MysqlManager::get_connection();
	   $id_ayah = $this->get_penduduk_id($nik_ayah);
	   $id_ibu = $this->get_penduduk_id($nik_ibu);
	   $result = $connection->query("insert into orang_tua set bapak_id = $id_ayah, ibu_id = $id_ibu");
	   check_error($connection);
	   MysqlManager::close_connection($connection);
   }

    public function check_orangtua($nik_ayah, $nik_ibu){
        $connection = MysqlManager::get_connection();
		$id_ayah = $this->get_penduduk_id($nik_ayah);
		$id_ibu = $this->get_penduduk_id($nik_ibu);
		$sql = "select count(*) as count from orang_tua where bapak_id = $id_ayah and ibu_id = $id_ibu";
		$result = $connection->query($sql);
		check_error($connection);
		$row = $result->fetch_object();
		MysqlManager::close_connection($connection);
		return $row->count;
	}
	
	public function get_penduduk_id($nik){
		$connection = MysqlManager::get_connection();
		$result = $connection->query("select id from penduduk where nik = '$nik'");
		$id = null;
		if($result){
			$row = $result->fetch_object();
			$id = $row->id;
		}		
		MysqlManager::close_connection($connection);
		return $id;
	}
}
?>
