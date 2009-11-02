<?php
if(isset($_GET['q']))
{
	include "../includes/helpers.inc.php";
    include "../includes/mysqli.inc.php";
	$resp = "";
	$page = $_GET['page'];
	$limit = $_GET['rows'];
	$sord = $_GET['sord'];
	$sidx = $_GET['sidx'];
	$total_pages = '';
	if(!$sidx)
	{
	    $sidx = 1;
	}

    $request = $_GET['q'];
    switch($request)
    {
        case "1":
            $sql = "select count(*) as count from access_groups";
			$result = $mysqli_connection->query($sql);
			check_error($mysqli_connection);
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
			$result = $mysqli_connection->query($sql);
			check_error($mysqli_connection);
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
			$mysqli_connection->close();
			echo json_encode($resp);
            break;
        case "2":
            
            break;
    }
}

if(isset($_POST['oper']))
{
    $operation = $_POST['oper'];
	switch($operation)
	{
        case "add":
		    break;
		case "edit":
		    break;
		case "del";
		    break;
	}
}
?>
