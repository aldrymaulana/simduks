<?php
include_once "controller_helpers.php";

class OrangTuaController
{
    public function __construct(){
	}

	public function get_id($nik_ayah, $nik_ibu){
		$connection = MysqlManager::get_connection();
		$result = $connection->query("select id from orang_tua where bapak_id = $nik_ayah and ibu_id = $nik_ibu");
		check_error($connection);
		$row = $result->fetch_object();
		MysqlManager::close_connection($connection);
		return $row->id;
	}

   public function insert($nik_ayah, $nik_ibu) {
       $connection = MysqlManager::get_connection();
	   $result = $connection->query("insert into orang_tua set bapak_id = $nik_ayah, ibu_id = $nik_ibu");
	   check_error($connection);
	   MysqlManager::close_connection($connection);
   }

    public function check_orangtua($nik_ayah, $nik_ibu){
        $connection = MysqlManager::get_connection();
		$sql = "select count(*) as count from orang_tua where bapak_id = $nik_ayah and ibu_id = $nik_ibu";
		$result = $connection->query($sql);
		check_error($connection);
		$row = $result->fetch_object();
		MysqlManager::close_connection($connection);
		return $row->count;
	}
}
?>
