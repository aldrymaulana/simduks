<?php
include "../includes/helpers.inc.php";
if(isset($_GET['q']))
{
	$request = $_GET['q'];
	$connection = MysqlManager::get_connection();
    switch($request)
    {
        case "1":
			$resp = "";
			$page = $_GET['page'];
			$limit = $_GET['rows'];
			$sord = $_GET['sord'];
			$sidx = $_GET['sidx'];
			$total_page = 0;
			if(!$sidx)
			{
				$sidx = 1;
			}
	
            $sql = "select count(*) as count from access_groups";
			$result = $connection->query($sql);
			check_error($connection);
			$row = $result->fetch_object();
			$count = $row->count;
			if($count and $count > 0)
			{
			    $total_pages = ceil($count / $limit);
			}
			else
			{
			    $total_pages = 0;
			}

			if($page > $total_page)
			{
			    $page = $total_page;
			}

			$start = $limit * $page - $limit;
			if($start < 0)
			{
			    $start = 0;
			}
			$sql = "select a.id as id, a.name as name, k.nama_kecamatan as nama_kecamatan from access_groups as a, kecamatan as k where a.kecamatan_id = k.id order by ".$sidx." ".$sord." limit ".$start.", ".$limit;
			$result = $connection->query($sql);
			check_error($connection);
			$resp->page = $page;
			$resp->total = $total_pages;
			$resp->records = $count;
			$i = 0;
			while($row = $result->fetch_object())
			{
                $resp->rows[$i]['id'] = $row->id;
				$resp->rows[$i]['cell'] = array($row->id, $row->name, $row->nama_kecamatan);
				$i++;
			}
			MysqlManager::close_connection($connection);
			echo json_encode($resp);
            break;
        case "2":
            
            break;
    }
}

if(isset($_POST['oper']))
{	
    $operation = $_POST['oper'];
	$connection = MysqlManager::get_connection();
	switch($operation)
	{
        case "add":
			$kecamatan_id = $_POST['kecamatan'];
			$name = $_POST['name'];
			$sql = "insert into access_groups set name = '$name', kecamatan_id = $kecamatan_id";
			$connection->query($sql);
			check_error($connection);			
			echo "ok";
		    break;
		case "edit":
			$id = $_POST['id'];
			$kecamatan = $_POST['kecamatan'];
			$name = $_POST['name'];
			$sql = "update access_groups set name = '$name', kecamatan_id = $kecamatan where id = $id";
			$connection->query($sql);
			check_error($connection);			
			echo "ok";
		    break;
		case "del";
			// delete groups automatically delete users too..
			$id = $_POST['id'];
			$sql = "delete from users where group_id = $id ";
			$connection->query($sql);
			check_error($connection);
			$sql = "delete from access_groups where id = $id";
			$connection->query($sql);
			check_error($connection);			
			echo "ok";
		    break;
	}
	MysqlManager::close_connection($connection);
}
?>